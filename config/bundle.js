(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
const extenso = require('extenso');
const BigNumber = require('bignumber.js');

$(document).ready(function () {
    $('#dob').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });
    $('#inicioVigenciaContrato').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });
    $('#terminoVigenciaContrato').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });
    $('#dataNascimento').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });

    $('#itemA').editable({
        title: 'ITEM A',
        rows: 10
    });
    $('#itemB').editable({
        title: 'ITEM B',
        rows: 10
    });
    $('#itemC').editable({
        title: 'ITEM C',
        rows: 10
    });
    $('#itensDoPacote').editable({
        title: 'ITENS DO PACOTE',
        rows: 10
    });
    $('#opcionaisDoPacote').editable({
        title: 'OPCIONAIS DO PACOTE',
        rows: 10
    });

    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';

    //make username editable
    $('#nome').editable();
    $('#nacionalidade').editable();
    $('#profissao').editable();
    $('#estadoCivil').editable();
    $('#identidade').editable();
    $('#telefone').editable();
    $('#cpf').editable();
    $('#enderecoCliente').editable();
    $('#nomePasseio').editable();
    $('#vagasSolicitadas').editable();
    $('#valorTotal').editable();
    $('#valorEntrada').editable();
    $('#previsaoPagamento').editable();
    $('#metodoPagamento').editable();
    $('#restantePagamento').editable();
    $('#dataDeHoje').editable();
    $('#assinaturaContratante').editable();
    $('#testemunha1').editable();
    $('#testemunha2').editable();

    
    $('select').on('blur',function () {
        const idCliente = $(location).attr('href').split('=').pop();
        $.get('api/infoPasseio.php', {
            id: this.value,
            idCliente: idCliente
        }).done(function(data) {
            data = JSON.parse(data);
            if(data.status === 0) return 0;
            const itensPacote = `ITENS DO PACOTE:<br/>${data.itensPacote}`
            const opcionaisPacote = `OPCIONAIS DO PACOTE:<br/>${data.opcionais}`
            const valorContrato = new BigNumber(data.valorContrato);
            // const valorString = String(valorContrato).replace('.', ',');
            // const valorString = String(valorContrato);
            // const valorEmExtenso = extenso(valorString).replace('inteiros', 'reais').replace('centésimos', 'centavos');
            const valorEmExtenso = '';

            $('#itensDoPacote').html(itensPacote)
            $('#opcionaisDoPacote').html(opcionaisPacote)
            $('#vagasSolicitadas').html(data.numeroVagas)
            $('#valorTotal').html(`${valorContrato.toFixed(2)} ( )`)
            // console.log(valorEmExtenso, valorString);
        })
    })
});
},{"bignumber.js":2,"extenso":3}],2:[function(require,module,exports){
;(function (globalObject) {
  'use strict';

/*
 *      bignumber.js v9.0.1
 *      A JavaScript library for arbitrary-precision arithmetic.
 *      https://github.com/MikeMcl/bignumber.js
 *      Copyright (c) 2020 Michael Mclaughlin <M8ch88l@gmail.com>
 *      MIT Licensed.
 *
 *      BigNumber.prototype methods     |  BigNumber methods
 *                                      |
 *      absoluteValue            abs    |  clone
 *      comparedTo                      |  config               set
 *      decimalPlaces            dp     |      DECIMAL_PLACES
 *      dividedBy                div    |      ROUNDING_MODE
 *      dividedToIntegerBy       idiv   |      EXPONENTIAL_AT
 *      exponentiatedBy          pow    |      RANGE
 *      integerValue                    |      CRYPTO
 *      isEqualTo                eq     |      MODULO_MODE
 *      isFinite                        |      POW_PRECISION
 *      isGreaterThan            gt     |      FORMAT
 *      isGreaterThanOrEqualTo   gte    |      ALPHABET
 *      isInteger                       |  isBigNumber
 *      isLessThan               lt     |  maximum              max
 *      isLessThanOrEqualTo      lte    |  minimum              min
 *      isNaN                           |  random
 *      isNegative                      |  sum
 *      isPositive                      |
 *      isZero                          |
 *      minus                           |
 *      modulo                   mod    |
 *      multipliedBy             times  |
 *      negated                         |
 *      plus                            |
 *      precision                sd     |
 *      shiftedBy                       |
 *      squareRoot               sqrt   |
 *      toExponential                   |
 *      toFixed                         |
 *      toFormat                        |
 *      toFraction                      |
 *      toJSON                          |
 *      toNumber                        |
 *      toPrecision                     |
 *      toString                        |
 *      valueOf                         |
 *
 */


  var BigNumber,
    isNumeric = /^-?(?:\d+(?:\.\d*)?|\.\d+)(?:e[+-]?\d+)?$/i,
    mathceil = Math.ceil,
    mathfloor = Math.floor,

    bignumberError = '[BigNumber Error] ',
    tooManyDigits = bignumberError + 'Number primitive has more than 15 significant digits: ',

    BASE = 1e14,
    LOG_BASE = 14,
    MAX_SAFE_INTEGER = 0x1fffffffffffff,         // 2^53 - 1
    // MAX_INT32 = 0x7fffffff,                   // 2^31 - 1
    POWS_TEN = [1, 10, 100, 1e3, 1e4, 1e5, 1e6, 1e7, 1e8, 1e9, 1e10, 1e11, 1e12, 1e13],
    SQRT_BASE = 1e7,

    // EDITABLE
    // The limit on the value of DECIMAL_PLACES, TO_EXP_NEG, TO_EXP_POS, MIN_EXP, MAX_EXP, and
    // the arguments to toExponential, toFixed, toFormat, and toPrecision.
    MAX = 1E9;                                   // 0 to MAX_INT32


  /*
   * Create and return a BigNumber constructor.
   */
  function clone(configObject) {
    var div, convertBase, parseNumeric,
      P = BigNumber.prototype = { constructor: BigNumber, toString: null, valueOf: null },
      ONE = new BigNumber(1),


      //----------------------------- EDITABLE CONFIG DEFAULTS -------------------------------


      // The default values below must be integers within the inclusive ranges stated.
      // The values can also be changed at run-time using BigNumber.set.

      // The maximum number of decimal places for operations involving division.
      DECIMAL_PLACES = 20,                     // 0 to MAX

      // The rounding mode used when rounding to the above decimal places, and when using
      // toExponential, toFixed, toFormat and toPrecision, and round (default value).
      // UP         0 Away from zero.
      // DOWN       1 Towards zero.
      // CEIL       2 Towards +Infinity.
      // FLOOR      3 Towards -Infinity.
      // HALF_UP    4 Towards nearest neighbour. If equidistant, up.
      // HALF_DOWN  5 Towards nearest neighbour. If equidistant, down.
      // HALF_EVEN  6 Towards nearest neighbour. If equidistant, towards even neighbour.
      // HALF_CEIL  7 Towards nearest neighbour. If equidistant, towards +Infinity.
      // HALF_FLOOR 8 Towards nearest neighbour. If equidistant, towards -Infinity.
      ROUNDING_MODE = 4,                       // 0 to 8

      // EXPONENTIAL_AT : [TO_EXP_NEG , TO_EXP_POS]

      // The exponent value at and beneath which toString returns exponential notation.
      // Number type: -7
      TO_EXP_NEG = -7,                         // 0 to -MAX

      // The exponent value at and above which toString returns exponential notation.
      // Number type: 21
      TO_EXP_POS = 21,                         // 0 to MAX

      // RANGE : [MIN_EXP, MAX_EXP]

      // The minimum exponent value, beneath which underflow to zero occurs.
      // Number type: -324  (5e-324)
      MIN_EXP = -1e7,                          // -1 to -MAX

      // The maximum exponent value, above which overflow to Infinity occurs.
      // Number type:  308  (1.7976931348623157e+308)
      // For MAX_EXP > 1e7, e.g. new BigNumber('1e100000000').plus(1) may be slow.
      MAX_EXP = 1e7,                           // 1 to MAX

      // Whether to use cryptographically-secure random number generation, if available.
      CRYPTO = false,                          // true or false

      // The modulo mode used when calculating the modulus: a mod n.
      // The quotient (q = a / n) is calculated according to the corresponding rounding mode.
      // The remainder (r) is calculated as: r = a - n * q.
      //
      // UP        0 The remainder is positive if the dividend is negative, else is negative.
      // DOWN      1 The remainder has the same sign as the dividend.
      //             This modulo mode is commonly known as 'truncated division' and is
      //             equivalent to (a % n) in JavaScript.
      // FLOOR     3 The remainder has the same sign as the divisor (Python %).
      // HALF_EVEN 6 This modulo mode implements the IEEE 754 remainder function.
      // EUCLID    9 Euclidian division. q = sign(n) * floor(a / abs(n)).
      //             The remainder is always positive.
      //
      // The truncated division, floored division, Euclidian division and IEEE 754 remainder
      // modes are commonly used for the modulus operation.
      // Although the other rounding modes can also be used, they may not give useful results.
      MODULO_MODE = 1,                         // 0 to 9

      // The maximum number of significant digits of the result of the exponentiatedBy operation.
      // If POW_PRECISION is 0, there will be unlimited significant digits.
      POW_PRECISION = 0,                    // 0 to MAX

      // The format specification used by the BigNumber.prototype.toFormat method.
      FORMAT = {
        prefix: '',
        groupSize: 3,
        secondaryGroupSize: 0,
        groupSeparator: ',',
        decimalSeparator: '.',
        fractionGroupSize: 0,
        fractionGroupSeparator: '\xA0',      // non-breaking space
        suffix: ''
      },

      // The alphabet used for base conversion. It must be at least 2 characters long, with no '+',
      // '-', '.', whitespace, or repeated character.
      // '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$_'
      ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyz';


    //------------------------------------------------------------------------------------------


    // CONSTRUCTOR


    /*
     * The BigNumber constructor and exported function.
     * Create and return a new instance of a BigNumber object.
     *
     * v {number|string|BigNumber} A numeric value.
     * [b] {number} The base of v. Integer, 2 to ALPHABET.length inclusive.
     */
    function BigNumber(v, b) {
      var alphabet, c, caseChanged, e, i, isNum, len, str,
        x = this;

      // Enable constructor call without `new`.
      if (!(x instanceof BigNumber)) return new BigNumber(v, b);

      if (b == null) {

        if (v && v._isBigNumber === true) {
          x.s = v.s;

          if (!v.c || v.e > MAX_EXP) {
            x.c = x.e = null;
          } else if (v.e < MIN_EXP) {
            x.c = [x.e = 0];
          } else {
            x.e = v.e;
            x.c = v.c.slice();
          }

          return;
        }

        if ((isNum = typeof v == 'number') && v * 0 == 0) {

          // Use `1 / n` to handle minus zero also.
          x.s = 1 / v < 0 ? (v = -v, -1) : 1;

          // Fast path for integers, where n < 2147483648 (2**31).
          if (v === ~~v) {
            for (e = 0, i = v; i >= 10; i /= 10, e++);

            if (e > MAX_EXP) {
              x.c = x.e = null;
            } else {
              x.e = e;
              x.c = [v];
            }

            return;
          }

          str = String(v);
        } else {

          if (!isNumeric.test(str = String(v))) return parseNumeric(x, str, isNum);

          x.s = str.charCodeAt(0) == 45 ? (str = str.slice(1), -1) : 1;
        }

        // Decimal point?
        if ((e = str.indexOf('.')) > -1) str = str.replace('.', '');

        // Exponential form?
        if ((i = str.search(/e/i)) > 0) {

          // Determine exponent.
          if (e < 0) e = i;
          e += +str.slice(i + 1);
          str = str.substring(0, i);
        } else if (e < 0) {

          // Integer.
          e = str.length;
        }

      } else {

        // '[BigNumber Error] Base {not a primitive number|not an integer|out of range}: {b}'
        intCheck(b, 2, ALPHABET.length, 'Base');

        // Allow exponential notation to be used with base 10 argument, while
        // also rounding to DECIMAL_PLACES as with other bases.
        if (b == 10) {
          x = new BigNumber(v);
          return round(x, DECIMAL_PLACES + x.e + 1, ROUNDING_MODE);
        }

        str = String(v);

        if (isNum = typeof v == 'number') {

          // Avoid potential interpretation of Infinity and NaN as base 44+ values.
          if (v * 0 != 0) return parseNumeric(x, str, isNum, b);

          x.s = 1 / v < 0 ? (str = str.slice(1), -1) : 1;

          // '[BigNumber Error] Number primitive has more than 15 significant digits: {n}'
          if (BigNumber.DEBUG && str.replace(/^0\.0*|\./, '').length > 15) {
            throw Error
             (tooManyDigits + v);
          }
        } else {
          x.s = str.charCodeAt(0) === 45 ? (str = str.slice(1), -1) : 1;
        }

        alphabet = ALPHABET.slice(0, b);
        e = i = 0;

        // Check that str is a valid base b number.
        // Don't use RegExp, so alphabet can contain special characters.
        for (len = str.length; i < len; i++) {
          if (alphabet.indexOf(c = str.charAt(i)) < 0) {
            if (c == '.') {

              // If '.' is not the first character and it has not be found before.
              if (i > e) {
                e = len;
                continue;
              }
            } else if (!caseChanged) {

              // Allow e.g. hexadecimal 'FF' as well as 'ff'.
              if (str == str.toUpperCase() && (str = str.toLowerCase()) ||
                  str == str.toLowerCase() && (str = str.toUpperCase())) {
                caseChanged = true;
                i = -1;
                e = 0;
                continue;
              }
            }

            return parseNumeric(x, String(v), isNum, b);
          }
        }

        // Prevent later check for length on converted number.
        isNum = false;
        str = convertBase(str, b, 10, x.s);

        // Decimal point?
        if ((e = str.indexOf('.')) > -1) str = str.replace('.', '');
        else e = str.length;
      }

      // Determine leading zeros.
      for (i = 0; str.charCodeAt(i) === 48; i++);

      // Determine trailing zeros.
      for (len = str.length; str.charCodeAt(--len) === 48;);

      if (str = str.slice(i, ++len)) {
        len -= i;

        // '[BigNumber Error] Number primitive has more than 15 significant digits: {n}'
        if (isNum && BigNumber.DEBUG &&
          len > 15 && (v > MAX_SAFE_INTEGER || v !== mathfloor(v))) {
            throw Error
             (tooManyDigits + (x.s * v));
        }

         // Overflow?
        if ((e = e - i - 1) > MAX_EXP) {

          // Infinity.
          x.c = x.e = null;

        // Underflow?
        } else if (e < MIN_EXP) {

          // Zero.
          x.c = [x.e = 0];
        } else {
          x.e = e;
          x.c = [];

          // Transform base

          // e is the base 10 exponent.
          // i is where to slice str to get the first element of the coefficient array.
          i = (e + 1) % LOG_BASE;
          if (e < 0) i += LOG_BASE;  // i < 1

          if (i < len) {
            if (i) x.c.push(+str.slice(0, i));

            for (len -= LOG_BASE; i < len;) {
              x.c.push(+str.slice(i, i += LOG_BASE));
            }

            i = LOG_BASE - (str = str.slice(i)).length;
          } else {
            i -= len;
          }

          for (; i--; str += '0');
          x.c.push(+str);
        }
      } else {

        // Zero.
        x.c = [x.e = 0];
      }
    }


    // CONSTRUCTOR PROPERTIES


    BigNumber.clone = clone;

    BigNumber.ROUND_UP = 0;
    BigNumber.ROUND_DOWN = 1;
    BigNumber.ROUND_CEIL = 2;
    BigNumber.ROUND_FLOOR = 3;
    BigNumber.ROUND_HALF_UP = 4;
    BigNumber.ROUND_HALF_DOWN = 5;
    BigNumber.ROUND_HALF_EVEN = 6;
    BigNumber.ROUND_HALF_CEIL = 7;
    BigNumber.ROUND_HALF_FLOOR = 8;
    BigNumber.EUCLID = 9;


    /*
     * Configure infrequently-changing library-wide settings.
     *
     * Accept an object with the following optional properties (if the value of a property is
     * a number, it must be an integer within the inclusive range stated):
     *
     *   DECIMAL_PLACES   {number}           0 to MAX
     *   ROUNDING_MODE    {number}           0 to 8
     *   EXPONENTIAL_AT   {number|number[]}  -MAX to MAX  or  [-MAX to 0, 0 to MAX]
     *   RANGE            {number|number[]}  -MAX to MAX (not zero)  or  [-MAX to -1, 1 to MAX]
     *   CRYPTO           {boolean}          true or false
     *   MODULO_MODE      {number}           0 to 9
     *   POW_PRECISION       {number}           0 to MAX
     *   ALPHABET         {string}           A string of two or more unique characters which does
     *                                       not contain '.'.
     *   FORMAT           {object}           An object with some of the following properties:
     *     prefix                 {string}
     *     groupSize              {number}
     *     secondaryGroupSize     {number}
     *     groupSeparator         {string}
     *     decimalSeparator       {string}
     *     fractionGroupSize      {number}
     *     fractionGroupSeparator {string}
     *     suffix                 {string}
     *
     * (The values assigned to the above FORMAT object properties are not checked for validity.)
     *
     * E.g.
     * BigNumber.config({ DECIMAL_PLACES : 20, ROUNDING_MODE : 4 })
     *
     * Ignore properties/parameters set to null or undefined, except for ALPHABET.
     *
     * Return an object with the properties current values.
     */
    BigNumber.config = BigNumber.set = function (obj) {
      var p, v;

      if (obj != null) {

        if (typeof obj == 'object') {

          // DECIMAL_PLACES {number} Integer, 0 to MAX inclusive.
          // '[BigNumber Error] DECIMAL_PLACES {not a primitive number|not an integer|out of range}: {v}'
          if (obj.hasOwnProperty(p = 'DECIMAL_PLACES')) {
            v = obj[p];
            intCheck(v, 0, MAX, p);
            DECIMAL_PLACES = v;
          }

          // ROUNDING_MODE {number} Integer, 0 to 8 inclusive.
          // '[BigNumber Error] ROUNDING_MODE {not a primitive number|not an integer|out of range}: {v}'
          if (obj.hasOwnProperty(p = 'ROUNDING_MODE')) {
            v = obj[p];
            intCheck(v, 0, 8, p);
            ROUNDING_MODE = v;
          }

          // EXPONENTIAL_AT {number|number[]}
          // Integer, -MAX to MAX inclusive or
          // [integer -MAX to 0 inclusive, 0 to MAX inclusive].
          // '[BigNumber Error] EXPONENTIAL_AT {not a primitive number|not an integer|out of range}: {v}'
          if (obj.hasOwnProperty(p = 'EXPONENTIAL_AT')) {
            v = obj[p];
            if (v && v.pop) {
              intCheck(v[0], -MAX, 0, p);
              intCheck(v[1], 0, MAX, p);
              TO_EXP_NEG = v[0];
              TO_EXP_POS = v[1];
            } else {
              intCheck(v, -MAX, MAX, p);
              TO_EXP_NEG = -(TO_EXP_POS = v < 0 ? -v : v);
            }
          }

          // RANGE {number|number[]} Non-zero integer, -MAX to MAX inclusive or
          // [integer -MAX to -1 inclusive, integer 1 to MAX inclusive].
          // '[BigNumber Error] RANGE {not a primitive number|not an integer|out of range|cannot be zero}: {v}'
          if (obj.hasOwnProperty(p = 'RANGE')) {
            v = obj[p];
            if (v && v.pop) {
              intCheck(v[0], -MAX, -1, p);
              intCheck(v[1], 1, MAX, p);
              MIN_EXP = v[0];
              MAX_EXP = v[1];
            } else {
              intCheck(v, -MAX, MAX, p);
              if (v) {
                MIN_EXP = -(MAX_EXP = v < 0 ? -v : v);
              } else {
                throw Error
                 (bignumberError + p + ' cannot be zero: ' + v);
              }
            }
          }

          // CRYPTO {boolean} true or false.
          // '[BigNumber Error] CRYPTO not true or false: {v}'
          // '[BigNumber Error] crypto unavailable'
          if (obj.hasOwnProperty(p = 'CRYPTO')) {
            v = obj[p];
            if (v === !!v) {
              if (v) {
                if (typeof crypto != 'undefined' && crypto &&
                 (crypto.getRandomValues || crypto.randomBytes)) {
                  CRYPTO = v;
                } else {
                  CRYPTO = !v;
                  throw Error
                   (bignumberError + 'crypto unavailable');
                }
              } else {
                CRYPTO = v;
              }
            } else {
              throw Error
               (bignumberError + p + ' not true or false: ' + v);
            }
          }

          // MODULO_MODE {number} Integer, 0 to 9 inclusive.
          // '[BigNumber Error] MODULO_MODE {not a primitive number|not an integer|out of range}: {v}'
          if (obj.hasOwnProperty(p = 'MODULO_MODE')) {
            v = obj[p];
            intCheck(v, 0, 9, p);
            MODULO_MODE = v;
          }

          // POW_PRECISION {number} Integer, 0 to MAX inclusive.
          // '[BigNumber Error] POW_PRECISION {not a primitive number|not an integer|out of range}: {v}'
          if (obj.hasOwnProperty(p = 'POW_PRECISION')) {
            v = obj[p];
            intCheck(v, 0, MAX, p);
            POW_PRECISION = v;
          }

          // FORMAT {object}
          // '[BigNumber Error] FORMAT not an object: {v}'
          if (obj.hasOwnProperty(p = 'FORMAT')) {
            v = obj[p];
            if (typeof v == 'object') FORMAT = v;
            else throw Error
             (bignumberError + p + ' not an object: ' + v);
          }

          // ALPHABET {string}
          // '[BigNumber Error] ALPHABET invalid: {v}'
          if (obj.hasOwnProperty(p = 'ALPHABET')) {
            v = obj[p];

            // Disallow if less than two characters,
            // or if it contains '+', '-', '.', whitespace, or a repeated character.
            if (typeof v == 'string' && !/^.?$|[+\-.\s]|(.).*\1/.test(v)) {
              ALPHABET = v;
            } else {
              throw Error
               (bignumberError + p + ' invalid: ' + v);
            }
          }

        } else {

          // '[BigNumber Error] Object expected: {v}'
          throw Error
           (bignumberError + 'Object expected: ' + obj);
        }
      }

      return {
        DECIMAL_PLACES: DECIMAL_PLACES,
        ROUNDING_MODE: ROUNDING_MODE,
        EXPONENTIAL_AT: [TO_EXP_NEG, TO_EXP_POS],
        RANGE: [MIN_EXP, MAX_EXP],
        CRYPTO: CRYPTO,
        MODULO_MODE: MODULO_MODE,
        POW_PRECISION: POW_PRECISION,
        FORMAT: FORMAT,
        ALPHABET: ALPHABET
      };
    };


    /*
     * Return true if v is a BigNumber instance, otherwise return false.
     *
     * If BigNumber.DEBUG is true, throw if a BigNumber instance is not well-formed.
     *
     * v {any}
     *
     * '[BigNumber Error] Invalid BigNumber: {v}'
     */
    BigNumber.isBigNumber = function (v) {
      if (!v || v._isBigNumber !== true) return false;
      if (!BigNumber.DEBUG) return true;

      var i, n,
        c = v.c,
        e = v.e,
        s = v.s;

      out: if ({}.toString.call(c) == '[object Array]') {

        if ((s === 1 || s === -1) && e >= -MAX && e <= MAX && e === mathfloor(e)) {

          // If the first element is zero, the BigNumber value must be zero.
          if (c[0] === 0) {
            if (e === 0 && c.length === 1) return true;
            break out;
          }

          // Calculate number of digits that c[0] should have, based on the exponent.
          i = (e + 1) % LOG_BASE;
          if (i < 1) i += LOG_BASE;

          // Calculate number of digits of c[0].
          //if (Math.ceil(Math.log(c[0] + 1) / Math.LN10) == i) {
          if (String(c[0]).length == i) {

            for (i = 0; i < c.length; i++) {
              n = c[i];
              if (n < 0 || n >= BASE || n !== mathfloor(n)) break out;
            }

            // Last element cannot be zero, unless it is the only element.
            if (n !== 0) return true;
          }
        }

      // Infinity/NaN
      } else if (c === null && e === null && (s === null || s === 1 || s === -1)) {
        return true;
      }

      throw Error
        (bignumberError + 'Invalid BigNumber: ' + v);
    };


    /*
     * Return a new BigNumber whose value is the maximum of the arguments.
     *
     * arguments {number|string|BigNumber}
     */
    BigNumber.maximum = BigNumber.max = function () {
      return maxOrMin(arguments, P.lt);
    };


    /*
     * Return a new BigNumber whose value is the minimum of the arguments.
     *
     * arguments {number|string|BigNumber}
     */
    BigNumber.minimum = BigNumber.min = function () {
      return maxOrMin(arguments, P.gt);
    };


    /*
     * Return a new BigNumber with a random value equal to or greater than 0 and less than 1,
     * and with dp, or DECIMAL_PLACES if dp is omitted, decimal places (or less if trailing
     * zeros are produced).
     *
     * [dp] {number} Decimal places. Integer, 0 to MAX inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {dp}'
     * '[BigNumber Error] crypto unavailable'
     */
    BigNumber.random = (function () {
      var pow2_53 = 0x20000000000000;

      // Return a 53 bit integer n, where 0 <= n < 9007199254740992.
      // Check if Math.random() produces more than 32 bits of randomness.
      // If it does, assume at least 53 bits are produced, otherwise assume at least 30 bits.
      // 0x40000000 is 2^30, 0x800000 is 2^23, 0x1fffff is 2^21 - 1.
      var random53bitInt = (Math.random() * pow2_53) & 0x1fffff
       ? function () { return mathfloor(Math.random() * pow2_53); }
       : function () { return ((Math.random() * 0x40000000 | 0) * 0x800000) +
         (Math.random() * 0x800000 | 0); };

      return function (dp) {
        var a, b, e, k, v,
          i = 0,
          c = [],
          rand = new BigNumber(ONE);

        if (dp == null) dp = DECIMAL_PLACES;
        else intCheck(dp, 0, MAX);

        k = mathceil(dp / LOG_BASE);

        if (CRYPTO) {

          // Browsers supporting crypto.getRandomValues.
          if (crypto.getRandomValues) {

            a = crypto.getRandomValues(new Uint32Array(k *= 2));

            for (; i < k;) {

              // 53 bits:
              // ((Math.pow(2, 32) - 1) * Math.pow(2, 21)).toString(2)
              // 11111 11111111 11111111 11111111 11100000 00000000 00000000
              // ((Math.pow(2, 32) - 1) >>> 11).toString(2)
              //                                     11111 11111111 11111111
              // 0x20000 is 2^21.
              v = a[i] * 0x20000 + (a[i + 1] >>> 11);

              // Rejection sampling:
              // 0 <= v < 9007199254740992
              // Probability that v >= 9e15, is
              // 7199254740992 / 9007199254740992 ~= 0.0008, i.e. 1 in 1251
              if (v >= 9e15) {
                b = crypto.getRandomValues(new Uint32Array(2));
                a[i] = b[0];
                a[i + 1] = b[1];
              } else {

                // 0 <= v <= 8999999999999999
                // 0 <= (v % 1e14) <= 99999999999999
                c.push(v % 1e14);
                i += 2;
              }
            }
            i = k / 2;

          // Node.js supporting crypto.randomBytes.
          } else if (crypto.randomBytes) {

            // buffer
            a = crypto.randomBytes(k *= 7);

            for (; i < k;) {

              // 0x1000000000000 is 2^48, 0x10000000000 is 2^40
              // 0x100000000 is 2^32, 0x1000000 is 2^24
              // 11111 11111111 11111111 11111111 11111111 11111111 11111111
              // 0 <= v < 9007199254740992
              v = ((a[i] & 31) * 0x1000000000000) + (a[i + 1] * 0x10000000000) +
                 (a[i + 2] * 0x100000000) + (a[i + 3] * 0x1000000) +
                 (a[i + 4] << 16) + (a[i + 5] << 8) + a[i + 6];

              if (v >= 9e15) {
                crypto.randomBytes(7).copy(a, i);
              } else {

                // 0 <= (v % 1e14) <= 99999999999999
                c.push(v % 1e14);
                i += 7;
              }
            }
            i = k / 7;
          } else {
            CRYPTO = false;
            throw Error
             (bignumberError + 'crypto unavailable');
          }
        }

        // Use Math.random.
        if (!CRYPTO) {

          for (; i < k;) {
            v = random53bitInt();
            if (v < 9e15) c[i++] = v % 1e14;
          }
        }

        k = c[--i];
        dp %= LOG_BASE;

        // Convert trailing digits to zeros according to dp.
        if (k && dp) {
          v = POWS_TEN[LOG_BASE - dp];
          c[i] = mathfloor(k / v) * v;
        }

        // Remove trailing elements which are zero.
        for (; c[i] === 0; c.pop(), i--);

        // Zero?
        if (i < 0) {
          c = [e = 0];
        } else {

          // Remove leading elements which are zero and adjust exponent accordingly.
          for (e = -1 ; c[0] === 0; c.splice(0, 1), e -= LOG_BASE);

          // Count the digits of the first element of c to determine leading zeros, and...
          for (i = 1, v = c[0]; v >= 10; v /= 10, i++);

          // adjust the exponent accordingly.
          if (i < LOG_BASE) e -= LOG_BASE - i;
        }

        rand.e = e;
        rand.c = c;
        return rand;
      };
    })();


    /*
     * Return a BigNumber whose value is the sum of the arguments.
     *
     * arguments {number|string|BigNumber}
     */
    BigNumber.sum = function () {
      var i = 1,
        args = arguments,
        sum = new BigNumber(args[0]);
      for (; i < args.length;) sum = sum.plus(args[i++]);
      return sum;
    };


    // PRIVATE FUNCTIONS


    // Called by BigNumber and BigNumber.prototype.toString.
    convertBase = (function () {
      var decimal = '0123456789';

      /*
       * Convert string of baseIn to an array of numbers of baseOut.
       * Eg. toBaseOut('255', 10, 16) returns [15, 15].
       * Eg. toBaseOut('ff', 16, 10) returns [2, 5, 5].
       */
      function toBaseOut(str, baseIn, baseOut, alphabet) {
        var j,
          arr = [0],
          arrL,
          i = 0,
          len = str.length;

        for (; i < len;) {
          for (arrL = arr.length; arrL--; arr[arrL] *= baseIn);

          arr[0] += alphabet.indexOf(str.charAt(i++));

          for (j = 0; j < arr.length; j++) {

            if (arr[j] > baseOut - 1) {
              if (arr[j + 1] == null) arr[j + 1] = 0;
              arr[j + 1] += arr[j] / baseOut | 0;
              arr[j] %= baseOut;
            }
          }
        }

        return arr.reverse();
      }

      // Convert a numeric string of baseIn to a numeric string of baseOut.
      // If the caller is toString, we are converting from base 10 to baseOut.
      // If the caller is BigNumber, we are converting from baseIn to base 10.
      return function (str, baseIn, baseOut, sign, callerIsToString) {
        var alphabet, d, e, k, r, x, xc, y,
          i = str.indexOf('.'),
          dp = DECIMAL_PLACES,
          rm = ROUNDING_MODE;

        // Non-integer.
        if (i >= 0) {
          k = POW_PRECISION;

          // Unlimited precision.
          POW_PRECISION = 0;
          str = str.replace('.', '');
          y = new BigNumber(baseIn);
          x = y.pow(str.length - i);
          POW_PRECISION = k;

          // Convert str as if an integer, then restore the fraction part by dividing the
          // result by its base raised to a power.

          y.c = toBaseOut(toFixedPoint(coeffToString(x.c), x.e, '0'),
           10, baseOut, decimal);
          y.e = y.c.length;
        }

        // Convert the number as integer.

        xc = toBaseOut(str, baseIn, baseOut, callerIsToString
         ? (alphabet = ALPHABET, decimal)
         : (alphabet = decimal, ALPHABET));

        // xc now represents str as an integer and converted to baseOut. e is the exponent.
        e = k = xc.length;

        // Remove trailing zeros.
        for (; xc[--k] == 0; xc.pop());

        // Zero?
        if (!xc[0]) return alphabet.charAt(0);

        // Does str represent an integer? If so, no need for the division.
        if (i < 0) {
          --e;
        } else {
          x.c = xc;
          x.e = e;

          // The sign is needed for correct rounding.
          x.s = sign;
          x = div(x, y, dp, rm, baseOut);
          xc = x.c;
          r = x.r;
          e = x.e;
        }

        // xc now represents str converted to baseOut.

        // THe index of the rounding digit.
        d = e + dp + 1;

        // The rounding digit: the digit to the right of the digit that may be rounded up.
        i = xc[d];

        // Look at the rounding digits and mode to determine whether to round up.

        k = baseOut / 2;
        r = r || d < 0 || xc[d + 1] != null;

        r = rm < 4 ? (i != null || r) && (rm == 0 || rm == (x.s < 0 ? 3 : 2))
              : i > k || i == k &&(rm == 4 || r || rm == 6 && xc[d - 1] & 1 ||
               rm == (x.s < 0 ? 8 : 7));

        // If the index of the rounding digit is not greater than zero, or xc represents
        // zero, then the result of the base conversion is zero or, if rounding up, a value
        // such as 0.00001.
        if (d < 1 || !xc[0]) {

          // 1^-dp or 0
          str = r ? toFixedPoint(alphabet.charAt(1), -dp, alphabet.charAt(0)) : alphabet.charAt(0);
        } else {

          // Truncate xc to the required number of decimal places.
          xc.length = d;

          // Round up?
          if (r) {

            // Rounding up may mean the previous digit has to be rounded up and so on.
            for (--baseOut; ++xc[--d] > baseOut;) {
              xc[d] = 0;

              if (!d) {
                ++e;
                xc = [1].concat(xc);
              }
            }
          }

          // Determine trailing zeros.
          for (k = xc.length; !xc[--k];);

          // E.g. [4, 11, 15] becomes 4bf.
          for (i = 0, str = ''; i <= k; str += alphabet.charAt(xc[i++]));

          // Add leading zeros, decimal point and trailing zeros as required.
          str = toFixedPoint(str, e, alphabet.charAt(0));
        }

        // The caller will add the sign.
        return str;
      };
    })();


    // Perform division in the specified base. Called by div and convertBase.
    div = (function () {

      // Assume non-zero x and k.
      function multiply(x, k, base) {
        var m, temp, xlo, xhi,
          carry = 0,
          i = x.length,
          klo = k % SQRT_BASE,
          khi = k / SQRT_BASE | 0;

        for (x = x.slice(); i--;) {
          xlo = x[i] % SQRT_BASE;
          xhi = x[i] / SQRT_BASE | 0;
          m = khi * xlo + xhi * klo;
          temp = klo * xlo + ((m % SQRT_BASE) * SQRT_BASE) + carry;
          carry = (temp / base | 0) + (m / SQRT_BASE | 0) + khi * xhi;
          x[i] = temp % base;
        }

        if (carry) x = [carry].concat(x);

        return x;
      }

      function compare(a, b, aL, bL) {
        var i, cmp;

        if (aL != bL) {
          cmp = aL > bL ? 1 : -1;
        } else {

          for (i = cmp = 0; i < aL; i++) {

            if (a[i] != b[i]) {
              cmp = a[i] > b[i] ? 1 : -1;
              break;
            }
          }
        }

        return cmp;
      }

      function subtract(a, b, aL, base) {
        var i = 0;

        // Subtract b from a.
        for (; aL--;) {
          a[aL] -= i;
          i = a[aL] < b[aL] ? 1 : 0;
          a[aL] = i * base + a[aL] - b[aL];
        }

        // Remove leading zeros.
        for (; !a[0] && a.length > 1; a.splice(0, 1));
      }

      // x: dividend, y: divisor.
      return function (x, y, dp, rm, base) {
        var cmp, e, i, more, n, prod, prodL, q, qc, rem, remL, rem0, xi, xL, yc0,
          yL, yz,
          s = x.s == y.s ? 1 : -1,
          xc = x.c,
          yc = y.c;

        // Either NaN, Infinity or 0?
        if (!xc || !xc[0] || !yc || !yc[0]) {

          return new BigNumber(

           // Return NaN if either NaN, or both Infinity or 0.
           !x.s || !y.s || (xc ? yc && xc[0] == yc[0] : !yc) ? NaN :

            // Return ±0 if x is ±0 or y is ±Infinity, or return ±Infinity as y is ±0.
            xc && xc[0] == 0 || !yc ? s * 0 : s / 0
         );
        }

        q = new BigNumber(s);
        qc = q.c = [];
        e = x.e - y.e;
        s = dp + e + 1;

        if (!base) {
          base = BASE;
          e = bitFloor(x.e / LOG_BASE) - bitFloor(y.e / LOG_BASE);
          s = s / LOG_BASE | 0;
        }

        // Result exponent may be one less then the current value of e.
        // The coefficients of the BigNumbers from convertBase may have trailing zeros.
        for (i = 0; yc[i] == (xc[i] || 0); i++);

        if (yc[i] > (xc[i] || 0)) e--;

        if (s < 0) {
          qc.push(1);
          more = true;
        } else {
          xL = xc.length;
          yL = yc.length;
          i = 0;
          s += 2;

          // Normalise xc and yc so highest order digit of yc is >= base / 2.

          n = mathfloor(base / (yc[0] + 1));

          // Not necessary, but to handle odd bases where yc[0] == (base / 2) - 1.
          // if (n > 1 || n++ == 1 && yc[0] < base / 2) {
          if (n > 1) {
            yc = multiply(yc, n, base);
            xc = multiply(xc, n, base);
            yL = yc.length;
            xL = xc.length;
          }

          xi = yL;
          rem = xc.slice(0, yL);
          remL = rem.length;

          // Add zeros to make remainder as long as divisor.
          for (; remL < yL; rem[remL++] = 0);
          yz = yc.slice();
          yz = [0].concat(yz);
          yc0 = yc[0];
          if (yc[1] >= base / 2) yc0++;
          // Not necessary, but to prevent trial digit n > base, when using base 3.
          // else if (base == 3 && yc0 == 1) yc0 = 1 + 1e-15;

          do {
            n = 0;

            // Compare divisor and remainder.
            cmp = compare(yc, rem, yL, remL);

            // If divisor < remainder.
            if (cmp < 0) {

              // Calculate trial digit, n.

              rem0 = rem[0];
              if (yL != remL) rem0 = rem0 * base + (rem[1] || 0);

              // n is how many times the divisor goes into the current remainder.
              n = mathfloor(rem0 / yc0);

              //  Algorithm:
              //  product = divisor multiplied by trial digit (n).
              //  Compare product and remainder.
              //  If product is greater than remainder:
              //    Subtract divisor from product, decrement trial digit.
              //  Subtract product from remainder.
              //  If product was less than remainder at the last compare:
              //    Compare new remainder and divisor.
              //    If remainder is greater than divisor:
              //      Subtract divisor from remainder, increment trial digit.

              if (n > 1) {

                // n may be > base only when base is 3.
                if (n >= base) n = base - 1;

                // product = divisor * trial digit.
                prod = multiply(yc, n, base);
                prodL = prod.length;
                remL = rem.length;

                // Compare product and remainder.
                // If product > remainder then trial digit n too high.
                // n is 1 too high about 5% of the time, and is not known to have
                // ever been more than 1 too high.
                while (compare(prod, rem, prodL, remL) == 1) {
                  n--;

                  // Subtract divisor from product.
                  subtract(prod, yL < prodL ? yz : yc, prodL, base);
                  prodL = prod.length;
                  cmp = 1;
                }
              } else {

                // n is 0 or 1, cmp is -1.
                // If n is 0, there is no need to compare yc and rem again below,
                // so change cmp to 1 to avoid it.
                // If n is 1, leave cmp as -1, so yc and rem are compared again.
                if (n == 0) {

                  // divisor < remainder, so n must be at least 1.
                  cmp = n = 1;
                }

                // product = divisor
                prod = yc.slice();
                prodL = prod.length;
              }

              if (prodL < remL) prod = [0].concat(prod);

              // Subtract product from remainder.
              subtract(rem, prod, remL, base);
              remL = rem.length;

               // If product was < remainder.
              if (cmp == -1) {

                // Compare divisor and new remainder.
                // If divisor < new remainder, subtract divisor from remainder.
                // Trial digit n too low.
                // n is 1 too low about 5% of the time, and very rarely 2 too low.
                while (compare(yc, rem, yL, remL) < 1) {
                  n++;

                  // Subtract divisor from remainder.
                  subtract(rem, yL < remL ? yz : yc, remL, base);
                  remL = rem.length;
                }
              }
            } else if (cmp === 0) {
              n++;
              rem = [0];
            } // else cmp === 1 and n will be 0

            // Add the next digit, n, to the result array.
            qc[i++] = n;

            // Update the remainder.
            if (rem[0]) {
              rem[remL++] = xc[xi] || 0;
            } else {
              rem = [xc[xi]];
              remL = 1;
            }
          } while ((xi++ < xL || rem[0] != null) && s--);

          more = rem[0] != null;

          // Leading zero?
          if (!qc[0]) qc.splice(0, 1);
        }

        if (base == BASE) {

          // To calculate q.e, first get the number of digits of qc[0].
          for (i = 1, s = qc[0]; s >= 10; s /= 10, i++);

          round(q, dp + (q.e = i + e * LOG_BASE - 1) + 1, rm, more);

        // Caller is convertBase.
        } else {
          q.e = e;
          q.r = +more;
        }

        return q;
      };
    })();


    /*
     * Return a string representing the value of BigNumber n in fixed-point or exponential
     * notation rounded to the specified decimal places or significant digits.
     *
     * n: a BigNumber.
     * i: the index of the last digit required (i.e. the digit that may be rounded up).
     * rm: the rounding mode.
     * id: 1 (toExponential) or 2 (toPrecision).
     */
    function format(n, i, rm, id) {
      var c0, e, ne, len, str;

      if (rm == null) rm = ROUNDING_MODE;
      else intCheck(rm, 0, 8);

      if (!n.c) return n.toString();

      c0 = n.c[0];
      ne = n.e;

      if (i == null) {
        str = coeffToString(n.c);
        str = id == 1 || id == 2 && (ne <= TO_EXP_NEG || ne >= TO_EXP_POS)
         ? toExponential(str, ne)
         : toFixedPoint(str, ne, '0');
      } else {
        n = round(new BigNumber(n), i, rm);

        // n.e may have changed if the value was rounded up.
        e = n.e;

        str = coeffToString(n.c);
        len = str.length;

        // toPrecision returns exponential notation if the number of significant digits
        // specified is less than the number of digits necessary to represent the integer
        // part of the value in fixed-point notation.

        // Exponential notation.
        if (id == 1 || id == 2 && (i <= e || e <= TO_EXP_NEG)) {

          // Append zeros?
          for (; len < i; str += '0', len++);
          str = toExponential(str, e);

        // Fixed-point notation.
        } else {
          i -= ne;
          str = toFixedPoint(str, e, '0');

          // Append zeros?
          if (e + 1 > len) {
            if (--i > 0) for (str += '.'; i--; str += '0');
          } else {
            i += e - len;
            if (i > 0) {
              if (e + 1 == len) str += '.';
              for (; i--; str += '0');
            }
          }
        }
      }

      return n.s < 0 && c0 ? '-' + str : str;
    }


    // Handle BigNumber.max and BigNumber.min.
    function maxOrMin(args, method) {
      var n,
        i = 1,
        m = new BigNumber(args[0]);

      for (; i < args.length; i++) {
        n = new BigNumber(args[i]);

        // If any number is NaN, return NaN.
        if (!n.s) {
          m = n;
          break;
        } else if (method.call(m, n)) {
          m = n;
        }
      }

      return m;
    }


    /*
     * Strip trailing zeros, calculate base 10 exponent and check against MIN_EXP and MAX_EXP.
     * Called by minus, plus and times.
     */
    function normalise(n, c, e) {
      var i = 1,
        j = c.length;

       // Remove trailing zeros.
      for (; !c[--j]; c.pop());

      // Calculate the base 10 exponent. First get the number of digits of c[0].
      for (j = c[0]; j >= 10; j /= 10, i++);

      // Overflow?
      if ((e = i + e * LOG_BASE - 1) > MAX_EXP) {

        // Infinity.
        n.c = n.e = null;

      // Underflow?
      } else if (e < MIN_EXP) {

        // Zero.
        n.c = [n.e = 0];
      } else {
        n.e = e;
        n.c = c;
      }

      return n;
    }


    // Handle values that fail the validity test in BigNumber.
    parseNumeric = (function () {
      var basePrefix = /^(-?)0([xbo])(?=\w[\w.]*$)/i,
        dotAfter = /^([^.]+)\.$/,
        dotBefore = /^\.([^.]+)$/,
        isInfinityOrNaN = /^-?(Infinity|NaN)$/,
        whitespaceOrPlus = /^\s*\+(?=[\w.])|^\s+|\s+$/g;

      return function (x, str, isNum, b) {
        var base,
          s = isNum ? str : str.replace(whitespaceOrPlus, '');

        // No exception on ±Infinity or NaN.
        if (isInfinityOrNaN.test(s)) {
          x.s = isNaN(s) ? null : s < 0 ? -1 : 1;
        } else {
          if (!isNum) {

            // basePrefix = /^(-?)0([xbo])(?=\w[\w.]*$)/i
            s = s.replace(basePrefix, function (m, p1, p2) {
              base = (p2 = p2.toLowerCase()) == 'x' ? 16 : p2 == 'b' ? 2 : 8;
              return !b || b == base ? p1 : m;
            });

            if (b) {
              base = b;

              // E.g. '1.' to '1', '.1' to '0.1'
              s = s.replace(dotAfter, '$1').replace(dotBefore, '0.$1');
            }

            if (str != s) return new BigNumber(s, base);
          }

          // '[BigNumber Error] Not a number: {n}'
          // '[BigNumber Error] Not a base {b} number: {n}'
          if (BigNumber.DEBUG) {
            throw Error
              (bignumberError + 'Not a' + (b ? ' base ' + b : '') + ' number: ' + str);
          }

          // NaN
          x.s = null;
        }

        x.c = x.e = null;
      }
    })();


    /*
     * Round x to sd significant digits using rounding mode rm. Check for over/under-flow.
     * If r is truthy, it is known that there are more digits after the rounding digit.
     */
    function round(x, sd, rm, r) {
      var d, i, j, k, n, ni, rd,
        xc = x.c,
        pows10 = POWS_TEN;

      // if x is not Infinity or NaN...
      if (xc) {

        // rd is the rounding digit, i.e. the digit after the digit that may be rounded up.
        // n is a base 1e14 number, the value of the element of array x.c containing rd.
        // ni is the index of n within x.c.
        // d is the number of digits of n.
        // i is the index of rd within n including leading zeros.
        // j is the actual index of rd within n (if < 0, rd is a leading zero).
        out: {

          // Get the number of digits of the first element of xc.
          for (d = 1, k = xc[0]; k >= 10; k /= 10, d++);
          i = sd - d;

          // If the rounding digit is in the first element of xc...
          if (i < 0) {
            i += LOG_BASE;
            j = sd;
            n = xc[ni = 0];

            // Get the rounding digit at index j of n.
            rd = n / pows10[d - j - 1] % 10 | 0;
          } else {
            ni = mathceil((i + 1) / LOG_BASE);

            if (ni >= xc.length) {

              if (r) {

                // Needed by sqrt.
                for (; xc.length <= ni; xc.push(0));
                n = rd = 0;
                d = 1;
                i %= LOG_BASE;
                j = i - LOG_BASE + 1;
              } else {
                break out;
              }
            } else {
              n = k = xc[ni];

              // Get the number of digits of n.
              for (d = 1; k >= 10; k /= 10, d++);

              // Get the index of rd within n.
              i %= LOG_BASE;

              // Get the index of rd within n, adjusted for leading zeros.
              // The number of leading zeros of n is given by LOG_BASE - d.
              j = i - LOG_BASE + d;

              // Get the rounding digit at index j of n.
              rd = j < 0 ? 0 : n / pows10[d - j - 1] % 10 | 0;
            }
          }

          r = r || sd < 0 ||

          // Are there any non-zero digits after the rounding digit?
          // The expression  n % pows10[d - j - 1]  returns all digits of n to the right
          // of the digit at j, e.g. if n is 908714 and j is 2, the expression gives 714.
           xc[ni + 1] != null || (j < 0 ? n : n % pows10[d - j - 1]);

          r = rm < 4
           ? (rd || r) && (rm == 0 || rm == (x.s < 0 ? 3 : 2))
           : rd > 5 || rd == 5 && (rm == 4 || r || rm == 6 &&

            // Check whether the digit to the left of the rounding digit is odd.
            ((i > 0 ? j > 0 ? n / pows10[d - j] : 0 : xc[ni - 1]) % 10) & 1 ||
             rm == (x.s < 0 ? 8 : 7));

          if (sd < 1 || !xc[0]) {
            xc.length = 0;

            if (r) {

              // Convert sd to decimal places.
              sd -= x.e + 1;

              // 1, 0.1, 0.01, 0.001, 0.0001 etc.
              xc[0] = pows10[(LOG_BASE - sd % LOG_BASE) % LOG_BASE];
              x.e = -sd || 0;
            } else {

              // Zero.
              xc[0] = x.e = 0;
            }

            return x;
          }

          // Remove excess digits.
          if (i == 0) {
            xc.length = ni;
            k = 1;
            ni--;
          } else {
            xc.length = ni + 1;
            k = pows10[LOG_BASE - i];

            // E.g. 56700 becomes 56000 if 7 is the rounding digit.
            // j > 0 means i > number of leading zeros of n.
            xc[ni] = j > 0 ? mathfloor(n / pows10[d - j] % pows10[j]) * k : 0;
          }

          // Round up?
          if (r) {

            for (; ;) {

              // If the digit to be rounded up is in the first element of xc...
              if (ni == 0) {

                // i will be the length of xc[0] before k is added.
                for (i = 1, j = xc[0]; j >= 10; j /= 10, i++);
                j = xc[0] += k;
                for (k = 1; j >= 10; j /= 10, k++);

                // if i != k the length has increased.
                if (i != k) {
                  x.e++;
                  if (xc[0] == BASE) xc[0] = 1;
                }

                break;
              } else {
                xc[ni] += k;
                if (xc[ni] != BASE) break;
                xc[ni--] = 0;
                k = 1;
              }
            }
          }

          // Remove trailing zeros.
          for (i = xc.length; xc[--i] === 0; xc.pop());
        }

        // Overflow? Infinity.
        if (x.e > MAX_EXP) {
          x.c = x.e = null;

        // Underflow? Zero.
        } else if (x.e < MIN_EXP) {
          x.c = [x.e = 0];
        }
      }

      return x;
    }


    function valueOf(n) {
      var str,
        e = n.e;

      if (e === null) return n.toString();

      str = coeffToString(n.c);

      str = e <= TO_EXP_NEG || e >= TO_EXP_POS
        ? toExponential(str, e)
        : toFixedPoint(str, e, '0');

      return n.s < 0 ? '-' + str : str;
    }


    // PROTOTYPE/INSTANCE METHODS


    /*
     * Return a new BigNumber whose value is the absolute value of this BigNumber.
     */
    P.absoluteValue = P.abs = function () {
      var x = new BigNumber(this);
      if (x.s < 0) x.s = 1;
      return x;
    };


    /*
     * Return
     *   1 if the value of this BigNumber is greater than the value of BigNumber(y, b),
     *   -1 if the value of this BigNumber is less than the value of BigNumber(y, b),
     *   0 if they have the same value,
     *   or null if the value of either is NaN.
     */
    P.comparedTo = function (y, b) {
      return compare(this, new BigNumber(y, b));
    };


    /*
     * If dp is undefined or null or true or false, return the number of decimal places of the
     * value of this BigNumber, or null if the value of this BigNumber is ±Infinity or NaN.
     *
     * Otherwise, if dp is a number, return a new BigNumber whose value is the value of this
     * BigNumber rounded to a maximum of dp decimal places using rounding mode rm, or
     * ROUNDING_MODE if rm is omitted.
     *
     * [dp] {number} Decimal places: integer, 0 to MAX inclusive.
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {dp|rm}'
     */
    P.decimalPlaces = P.dp = function (dp, rm) {
      var c, n, v,
        x = this;

      if (dp != null) {
        intCheck(dp, 0, MAX);
        if (rm == null) rm = ROUNDING_MODE;
        else intCheck(rm, 0, 8);

        return round(new BigNumber(x), dp + x.e + 1, rm);
      }

      if (!(c = x.c)) return null;
      n = ((v = c.length - 1) - bitFloor(this.e / LOG_BASE)) * LOG_BASE;

      // Subtract the number of trailing zeros of the last number.
      if (v = c[v]) for (; v % 10 == 0; v /= 10, n--);
      if (n < 0) n = 0;

      return n;
    };


    /*
     *  n / 0 = I
     *  n / N = N
     *  n / I = 0
     *  0 / n = 0
     *  0 / 0 = N
     *  0 / N = N
     *  0 / I = 0
     *  N / n = N
     *  N / 0 = N
     *  N / N = N
     *  N / I = N
     *  I / n = I
     *  I / 0 = I
     *  I / N = N
     *  I / I = N
     *
     * Return a new BigNumber whose value is the value of this BigNumber divided by the value of
     * BigNumber(y, b), rounded according to DECIMAL_PLACES and ROUNDING_MODE.
     */
    P.dividedBy = P.div = function (y, b) {
      return div(this, new BigNumber(y, b), DECIMAL_PLACES, ROUNDING_MODE);
    };


    /*
     * Return a new BigNumber whose value is the integer part of dividing the value of this
     * BigNumber by the value of BigNumber(y, b).
     */
    P.dividedToIntegerBy = P.idiv = function (y, b) {
      return div(this, new BigNumber(y, b), 0, 1);
    };


    /*
     * Return a BigNumber whose value is the value of this BigNumber exponentiated by n.
     *
     * If m is present, return the result modulo m.
     * If n is negative round according to DECIMAL_PLACES and ROUNDING_MODE.
     * If POW_PRECISION is non-zero and m is not present, round to POW_PRECISION using ROUNDING_MODE.
     *
     * The modular power operation works efficiently when x, n, and m are integers, otherwise it
     * is equivalent to calculating x.exponentiatedBy(n).modulo(m) with a POW_PRECISION of 0.
     *
     * n {number|string|BigNumber} The exponent. An integer.
     * [m] {number|string|BigNumber} The modulus.
     *
     * '[BigNumber Error] Exponent not an integer: {n}'
     */
    P.exponentiatedBy = P.pow = function (n, m) {
      var half, isModExp, i, k, more, nIsBig, nIsNeg, nIsOdd, y,
        x = this;

      n = new BigNumber(n);

      // Allow NaN and ±Infinity, but not other non-integers.
      if (n.c && !n.isInteger()) {
        throw Error
          (bignumberError + 'Exponent not an integer: ' + valueOf(n));
      }

      if (m != null) m = new BigNumber(m);

      // Exponent of MAX_SAFE_INTEGER is 15.
      nIsBig = n.e > 14;

      // If x is NaN, ±Infinity, ±0 or ±1, or n is ±Infinity, NaN or ±0.
      if (!x.c || !x.c[0] || x.c[0] == 1 && !x.e && x.c.length == 1 || !n.c || !n.c[0]) {

        // The sign of the result of pow when x is negative depends on the evenness of n.
        // If +n overflows to ±Infinity, the evenness of n would be not be known.
        y = new BigNumber(Math.pow(+valueOf(x), nIsBig ? 2 - isOdd(n) : +valueOf(n)));
        return m ? y.mod(m) : y;
      }

      nIsNeg = n.s < 0;

      if (m) {

        // x % m returns NaN if abs(m) is zero, or m is NaN.
        if (m.c ? !m.c[0] : !m.s) return new BigNumber(NaN);

        isModExp = !nIsNeg && x.isInteger() && m.isInteger();

        if (isModExp) x = x.mod(m);

      // Overflow to ±Infinity: >=2**1e10 or >=1.0000024**1e15.
      // Underflow to ±0: <=0.79**1e10 or <=0.9999975**1e15.
      } else if (n.e > 9 && (x.e > 0 || x.e < -1 || (x.e == 0
        // [1, 240000000]
        ? x.c[0] > 1 || nIsBig && x.c[1] >= 24e7
        // [80000000000000]  [99999750000000]
        : x.c[0] < 8e13 || nIsBig && x.c[0] <= 9999975e7))) {

        // If x is negative and n is odd, k = -0, else k = 0.
        k = x.s < 0 && isOdd(n) ? -0 : 0;

        // If x >= 1, k = ±Infinity.
        if (x.e > -1) k = 1 / k;

        // If n is negative return ±0, else return ±Infinity.
        return new BigNumber(nIsNeg ? 1 / k : k);

      } else if (POW_PRECISION) {

        // Truncating each coefficient array to a length of k after each multiplication
        // equates to truncating significant digits to POW_PRECISION + [28, 41],
        // i.e. there will be a minimum of 28 guard digits retained.
        k = mathceil(POW_PRECISION / LOG_BASE + 2);
      }

      if (nIsBig) {
        half = new BigNumber(0.5);
        if (nIsNeg) n.s = 1;
        nIsOdd = isOdd(n);
      } else {
        i = Math.abs(+valueOf(n));
        nIsOdd = i % 2;
      }

      y = new BigNumber(ONE);

      // Performs 54 loop iterations for n of 9007199254740991.
      for (; ;) {

        if (nIsOdd) {
          y = y.times(x);
          if (!y.c) break;

          if (k) {
            if (y.c.length > k) y.c.length = k;
          } else if (isModExp) {
            y = y.mod(m);    //y = y.minus(div(y, m, 0, MODULO_MODE).times(m));
          }
        }

        if (i) {
          i = mathfloor(i / 2);
          if (i === 0) break;
          nIsOdd = i % 2;
        } else {
          n = n.times(half);
          round(n, n.e + 1, 1);

          if (n.e > 14) {
            nIsOdd = isOdd(n);
          } else {
            i = +valueOf(n);
            if (i === 0) break;
            nIsOdd = i % 2;
          }
        }

        x = x.times(x);

        if (k) {
          if (x.c && x.c.length > k) x.c.length = k;
        } else if (isModExp) {
          x = x.mod(m);    //x = x.minus(div(x, m, 0, MODULO_MODE).times(m));
        }
      }

      if (isModExp) return y;
      if (nIsNeg) y = ONE.div(y);

      return m ? y.mod(m) : k ? round(y, POW_PRECISION, ROUNDING_MODE, more) : y;
    };


    /*
     * Return a new BigNumber whose value is the value of this BigNumber rounded to an integer
     * using rounding mode rm, or ROUNDING_MODE if rm is omitted.
     *
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {rm}'
     */
    P.integerValue = function (rm) {
      var n = new BigNumber(this);
      if (rm == null) rm = ROUNDING_MODE;
      else intCheck(rm, 0, 8);
      return round(n, n.e + 1, rm);
    };


    /*
     * Return true if the value of this BigNumber is equal to the value of BigNumber(y, b),
     * otherwise return false.
     */
    P.isEqualTo = P.eq = function (y, b) {
      return compare(this, new BigNumber(y, b)) === 0;
    };


    /*
     * Return true if the value of this BigNumber is a finite number, otherwise return false.
     */
    P.isFinite = function () {
      return !!this.c;
    };


    /*
     * Return true if the value of this BigNumber is greater than the value of BigNumber(y, b),
     * otherwise return false.
     */
    P.isGreaterThan = P.gt = function (y, b) {
      return compare(this, new BigNumber(y, b)) > 0;
    };


    /*
     * Return true if the value of this BigNumber is greater than or equal to the value of
     * BigNumber(y, b), otherwise return false.
     */
    P.isGreaterThanOrEqualTo = P.gte = function (y, b) {
      return (b = compare(this, new BigNumber(y, b))) === 1 || b === 0;

    };


    /*
     * Return true if the value of this BigNumber is an integer, otherwise return false.
     */
    P.isInteger = function () {
      return !!this.c && bitFloor(this.e / LOG_BASE) > this.c.length - 2;
    };


    /*
     * Return true if the value of this BigNumber is less than the value of BigNumber(y, b),
     * otherwise return false.
     */
    P.isLessThan = P.lt = function (y, b) {
      return compare(this, new BigNumber(y, b)) < 0;
    };


    /*
     * Return true if the value of this BigNumber is less than or equal to the value of
     * BigNumber(y, b), otherwise return false.
     */
    P.isLessThanOrEqualTo = P.lte = function (y, b) {
      return (b = compare(this, new BigNumber(y, b))) === -1 || b === 0;
    };


    /*
     * Return true if the value of this BigNumber is NaN, otherwise return false.
     */
    P.isNaN = function () {
      return !this.s;
    };


    /*
     * Return true if the value of this BigNumber is negative, otherwise return false.
     */
    P.isNegative = function () {
      return this.s < 0;
    };


    /*
     * Return true if the value of this BigNumber is positive, otherwise return false.
     */
    P.isPositive = function () {
      return this.s > 0;
    };


    /*
     * Return true if the value of this BigNumber is 0 or -0, otherwise return false.
     */
    P.isZero = function () {
      return !!this.c && this.c[0] == 0;
    };


    /*
     *  n - 0 = n
     *  n - N = N
     *  n - I = -I
     *  0 - n = -n
     *  0 - 0 = 0
     *  0 - N = N
     *  0 - I = -I
     *  N - n = N
     *  N - 0 = N
     *  N - N = N
     *  N - I = N
     *  I - n = I
     *  I - 0 = I
     *  I - N = N
     *  I - I = N
     *
     * Return a new BigNumber whose value is the value of this BigNumber minus the value of
     * BigNumber(y, b).
     */
    P.minus = function (y, b) {
      var i, j, t, xLTy,
        x = this,
        a = x.s;

      y = new BigNumber(y, b);
      b = y.s;

      // Either NaN?
      if (!a || !b) return new BigNumber(NaN);

      // Signs differ?
      if (a != b) {
        y.s = -b;
        return x.plus(y);
      }

      var xe = x.e / LOG_BASE,
        ye = y.e / LOG_BASE,
        xc = x.c,
        yc = y.c;

      if (!xe || !ye) {

        // Either Infinity?
        if (!xc || !yc) return xc ? (y.s = -b, y) : new BigNumber(yc ? x : NaN);

        // Either zero?
        if (!xc[0] || !yc[0]) {

          // Return y if y is non-zero, x if x is non-zero, or zero if both are zero.
          return yc[0] ? (y.s = -b, y) : new BigNumber(xc[0] ? x :

           // IEEE 754 (2008) 6.3: n - n = -0 when rounding to -Infinity
           ROUNDING_MODE == 3 ? -0 : 0);
        }
      }

      xe = bitFloor(xe);
      ye = bitFloor(ye);
      xc = xc.slice();

      // Determine which is the bigger number.
      if (a = xe - ye) {

        if (xLTy = a < 0) {
          a = -a;
          t = xc;
        } else {
          ye = xe;
          t = yc;
        }

        t.reverse();

        // Prepend zeros to equalise exponents.
        for (b = a; b--; t.push(0));
        t.reverse();
      } else {

        // Exponents equal. Check digit by digit.
        j = (xLTy = (a = xc.length) < (b = yc.length)) ? a : b;

        for (a = b = 0; b < j; b++) {

          if (xc[b] != yc[b]) {
            xLTy = xc[b] < yc[b];
            break;
          }
        }
      }

      // x < y? Point xc to the array of the bigger number.
      if (xLTy) t = xc, xc = yc, yc = t, y.s = -y.s;

      b = (j = yc.length) - (i = xc.length);

      // Append zeros to xc if shorter.
      // No need to add zeros to yc if shorter as subtract only needs to start at yc.length.
      if (b > 0) for (; b--; xc[i++] = 0);
      b = BASE - 1;

      // Subtract yc from xc.
      for (; j > a;) {

        if (xc[--j] < yc[j]) {
          for (i = j; i && !xc[--i]; xc[i] = b);
          --xc[i];
          xc[j] += BASE;
        }

        xc[j] -= yc[j];
      }

      // Remove leading zeros and adjust exponent accordingly.
      for (; xc[0] == 0; xc.splice(0, 1), --ye);

      // Zero?
      if (!xc[0]) {

        // Following IEEE 754 (2008) 6.3,
        // n - n = +0  but  n - n = -0  when rounding towards -Infinity.
        y.s = ROUNDING_MODE == 3 ? -1 : 1;
        y.c = [y.e = 0];
        return y;
      }

      // No need to check for Infinity as +x - +y != Infinity && -x - -y != Infinity
      // for finite x and y.
      return normalise(y, xc, ye);
    };


    /*
     *   n % 0 =  N
     *   n % N =  N
     *   n % I =  n
     *   0 % n =  0
     *  -0 % n = -0
     *   0 % 0 =  N
     *   0 % N =  N
     *   0 % I =  0
     *   N % n =  N
     *   N % 0 =  N
     *   N % N =  N
     *   N % I =  N
     *   I % n =  N
     *   I % 0 =  N
     *   I % N =  N
     *   I % I =  N
     *
     * Return a new BigNumber whose value is the value of this BigNumber modulo the value of
     * BigNumber(y, b). The result depends on the value of MODULO_MODE.
     */
    P.modulo = P.mod = function (y, b) {
      var q, s,
        x = this;

      y = new BigNumber(y, b);

      // Return NaN if x is Infinity or NaN, or y is NaN or zero.
      if (!x.c || !y.s || y.c && !y.c[0]) {
        return new BigNumber(NaN);

      // Return x if y is Infinity or x is zero.
      } else if (!y.c || x.c && !x.c[0]) {
        return new BigNumber(x);
      }

      if (MODULO_MODE == 9) {

        // Euclidian division: q = sign(y) * floor(x / abs(y))
        // r = x - qy    where  0 <= r < abs(y)
        s = y.s;
        y.s = 1;
        q = div(x, y, 0, 3);
        y.s = s;
        q.s *= s;
      } else {
        q = div(x, y, 0, MODULO_MODE);
      }

      y = x.minus(q.times(y));

      // To match JavaScript %, ensure sign of zero is sign of dividend.
      if (!y.c[0] && MODULO_MODE == 1) y.s = x.s;

      return y;
    };


    /*
     *  n * 0 = 0
     *  n * N = N
     *  n * I = I
     *  0 * n = 0
     *  0 * 0 = 0
     *  0 * N = N
     *  0 * I = N
     *  N * n = N
     *  N * 0 = N
     *  N * N = N
     *  N * I = N
     *  I * n = I
     *  I * 0 = N
     *  I * N = N
     *  I * I = I
     *
     * Return a new BigNumber whose value is the value of this BigNumber multiplied by the value
     * of BigNumber(y, b).
     */
    P.multipliedBy = P.times = function (y, b) {
      var c, e, i, j, k, m, xcL, xlo, xhi, ycL, ylo, yhi, zc,
        base, sqrtBase,
        x = this,
        xc = x.c,
        yc = (y = new BigNumber(y, b)).c;

      // Either NaN, ±Infinity or ±0?
      if (!xc || !yc || !xc[0] || !yc[0]) {

        // Return NaN if either is NaN, or one is 0 and the other is Infinity.
        if (!x.s || !y.s || xc && !xc[0] && !yc || yc && !yc[0] && !xc) {
          y.c = y.e = y.s = null;
        } else {
          y.s *= x.s;

          // Return ±Infinity if either is ±Infinity.
          if (!xc || !yc) {
            y.c = y.e = null;

          // Return ±0 if either is ±0.
          } else {
            y.c = [0];
            y.e = 0;
          }
        }

        return y;
      }

      e = bitFloor(x.e / LOG_BASE) + bitFloor(y.e / LOG_BASE);
      y.s *= x.s;
      xcL = xc.length;
      ycL = yc.length;

      // Ensure xc points to longer array and xcL to its length.
      if (xcL < ycL) zc = xc, xc = yc, yc = zc, i = xcL, xcL = ycL, ycL = i;

      // Initialise the result array with zeros.
      for (i = xcL + ycL, zc = []; i--; zc.push(0));

      base = BASE;
      sqrtBase = SQRT_BASE;

      for (i = ycL; --i >= 0;) {
        c = 0;
        ylo = yc[i] % sqrtBase;
        yhi = yc[i] / sqrtBase | 0;

        for (k = xcL, j = i + k; j > i;) {
          xlo = xc[--k] % sqrtBase;
          xhi = xc[k] / sqrtBase | 0;
          m = yhi * xlo + xhi * ylo;
          xlo = ylo * xlo + ((m % sqrtBase) * sqrtBase) + zc[j] + c;
          c = (xlo / base | 0) + (m / sqrtBase | 0) + yhi * xhi;
          zc[j--] = xlo % base;
        }

        zc[j] = c;
      }

      if (c) {
        ++e;
      } else {
        zc.splice(0, 1);
      }

      return normalise(y, zc, e);
    };


    /*
     * Return a new BigNumber whose value is the value of this BigNumber negated,
     * i.e. multiplied by -1.
     */
    P.negated = function () {
      var x = new BigNumber(this);
      x.s = -x.s || null;
      return x;
    };


    /*
     *  n + 0 = n
     *  n + N = N
     *  n + I = I
     *  0 + n = n
     *  0 + 0 = 0
     *  0 + N = N
     *  0 + I = I
     *  N + n = N
     *  N + 0 = N
     *  N + N = N
     *  N + I = N
     *  I + n = I
     *  I + 0 = I
     *  I + N = N
     *  I + I = I
     *
     * Return a new BigNumber whose value is the value of this BigNumber plus the value of
     * BigNumber(y, b).
     */
    P.plus = function (y, b) {
      var t,
        x = this,
        a = x.s;

      y = new BigNumber(y, b);
      b = y.s;

      // Either NaN?
      if (!a || !b) return new BigNumber(NaN);

      // Signs differ?
       if (a != b) {
        y.s = -b;
        return x.minus(y);
      }

      var xe = x.e / LOG_BASE,
        ye = y.e / LOG_BASE,
        xc = x.c,
        yc = y.c;

      if (!xe || !ye) {

        // Return ±Infinity if either ±Infinity.
        if (!xc || !yc) return new BigNumber(a / 0);

        // Either zero?
        // Return y if y is non-zero, x if x is non-zero, or zero if both are zero.
        if (!xc[0] || !yc[0]) return yc[0] ? y : new BigNumber(xc[0] ? x : a * 0);
      }

      xe = bitFloor(xe);
      ye = bitFloor(ye);
      xc = xc.slice();

      // Prepend zeros to equalise exponents. Faster to use reverse then do unshifts.
      if (a = xe - ye) {
        if (a > 0) {
          ye = xe;
          t = yc;
        } else {
          a = -a;
          t = xc;
        }

        t.reverse();
        for (; a--; t.push(0));
        t.reverse();
      }

      a = xc.length;
      b = yc.length;

      // Point xc to the longer array, and b to the shorter length.
      if (a - b < 0) t = yc, yc = xc, xc = t, b = a;

      // Only start adding at yc.length - 1 as the further digits of xc can be ignored.
      for (a = 0; b;) {
        a = (xc[--b] = xc[b] + yc[b] + a) / BASE | 0;
        xc[b] = BASE === xc[b] ? 0 : xc[b] % BASE;
      }

      if (a) {
        xc = [a].concat(xc);
        ++ye;
      }

      // No need to check for zero, as +x + +y != 0 && -x + -y != 0
      // ye = MAX_EXP + 1 possible
      return normalise(y, xc, ye);
    };


    /*
     * If sd is undefined or null or true or false, return the number of significant digits of
     * the value of this BigNumber, or null if the value of this BigNumber is ±Infinity or NaN.
     * If sd is true include integer-part trailing zeros in the count.
     *
     * Otherwise, if sd is a number, return a new BigNumber whose value is the value of this
     * BigNumber rounded to a maximum of sd significant digits using rounding mode rm, or
     * ROUNDING_MODE if rm is omitted.
     *
     * sd {number|boolean} number: significant digits: integer, 1 to MAX inclusive.
     *                     boolean: whether to count integer-part trailing zeros: true or false.
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {sd|rm}'
     */
    P.precision = P.sd = function (sd, rm) {
      var c, n, v,
        x = this;

      if (sd != null && sd !== !!sd) {
        intCheck(sd, 1, MAX);
        if (rm == null) rm = ROUNDING_MODE;
        else intCheck(rm, 0, 8);

        return round(new BigNumber(x), sd, rm);
      }

      if (!(c = x.c)) return null;
      v = c.length - 1;
      n = v * LOG_BASE + 1;

      if (v = c[v]) {

        // Subtract the number of trailing zeros of the last element.
        for (; v % 10 == 0; v /= 10, n--);

        // Add the number of digits of the first element.
        for (v = c[0]; v >= 10; v /= 10, n++);
      }

      if (sd && x.e + 1 > n) n = x.e + 1;

      return n;
    };


    /*
     * Return a new BigNumber whose value is the value of this BigNumber shifted by k places
     * (powers of 10). Shift to the right if n > 0, and to the left if n < 0.
     *
     * k {number} Integer, -MAX_SAFE_INTEGER to MAX_SAFE_INTEGER inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {k}'
     */
    P.shiftedBy = function (k) {
      intCheck(k, -MAX_SAFE_INTEGER, MAX_SAFE_INTEGER);
      return this.times('1e' + k);
    };


    /*
     *  sqrt(-n) =  N
     *  sqrt(N) =  N
     *  sqrt(-I) =  N
     *  sqrt(I) =  I
     *  sqrt(0) =  0
     *  sqrt(-0) = -0
     *
     * Return a new BigNumber whose value is the square root of the value of this BigNumber,
     * rounded according to DECIMAL_PLACES and ROUNDING_MODE.
     */
    P.squareRoot = P.sqrt = function () {
      var m, n, r, rep, t,
        x = this,
        c = x.c,
        s = x.s,
        e = x.e,
        dp = DECIMAL_PLACES + 4,
        half = new BigNumber('0.5');

      // Negative/NaN/Infinity/zero?
      if (s !== 1 || !c || !c[0]) {
        return new BigNumber(!s || s < 0 && (!c || c[0]) ? NaN : c ? x : 1 / 0);
      }

      // Initial estimate.
      s = Math.sqrt(+valueOf(x));

      // Math.sqrt underflow/overflow?
      // Pass x to Math.sqrt as integer, then adjust the exponent of the result.
      if (s == 0 || s == 1 / 0) {
        n = coeffToString(c);
        if ((n.length + e) % 2 == 0) n += '0';
        s = Math.sqrt(+n);
        e = bitFloor((e + 1) / 2) - (e < 0 || e % 2);

        if (s == 1 / 0) {
          n = '5e' + e;
        } else {
          n = s.toExponential();
          n = n.slice(0, n.indexOf('e') + 1) + e;
        }

        r = new BigNumber(n);
      } else {
        r = new BigNumber(s + '');
      }

      // Check for zero.
      // r could be zero if MIN_EXP is changed after the this value was created.
      // This would cause a division by zero (x/t) and hence Infinity below, which would cause
      // coeffToString to throw.
      if (r.c[0]) {
        e = r.e;
        s = e + dp;
        if (s < 3) s = 0;

        // Newton-Raphson iteration.
        for (; ;) {
          t = r;
          r = half.times(t.plus(div(x, t, dp, 1)));

          if (coeffToString(t.c).slice(0, s) === (n = coeffToString(r.c)).slice(0, s)) {

            // The exponent of r may here be one less than the final result exponent,
            // e.g 0.0009999 (e-4) --> 0.001 (e-3), so adjust s so the rounding digits
            // are indexed correctly.
            if (r.e < e) --s;
            n = n.slice(s - 3, s + 1);

            // The 4th rounding digit may be in error by -1 so if the 4 rounding digits
            // are 9999 or 4999 (i.e. approaching a rounding boundary) continue the
            // iteration.
            if (n == '9999' || !rep && n == '4999') {

              // On the first iteration only, check to see if rounding up gives the
              // exact result as the nines may infinitely repeat.
              if (!rep) {
                round(t, t.e + DECIMAL_PLACES + 2, 0);

                if (t.times(t).eq(x)) {
                  r = t;
                  break;
                }
              }

              dp += 4;
              s += 4;
              rep = 1;
            } else {

              // If rounding digits are null, 0{0,4} or 50{0,3}, check for exact
              // result. If not, then there are further digits and m will be truthy.
              if (!+n || !+n.slice(1) && n.charAt(0) == '5') {

                // Truncate to the first rounding digit.
                round(r, r.e + DECIMAL_PLACES + 2, 1);
                m = !r.times(r).eq(x);
              }

              break;
            }
          }
        }
      }

      return round(r, r.e + DECIMAL_PLACES + 1, ROUNDING_MODE, m);
    };


    /*
     * Return a string representing the value of this BigNumber in exponential notation and
     * rounded using ROUNDING_MODE to dp fixed decimal places.
     *
     * [dp] {number} Decimal places. Integer, 0 to MAX inclusive.
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {dp|rm}'
     */
    P.toExponential = function (dp, rm) {
      if (dp != null) {
        intCheck(dp, 0, MAX);
        dp++;
      }
      return format(this, dp, rm, 1);
    };


    /*
     * Return a string representing the value of this BigNumber in fixed-point notation rounding
     * to dp fixed decimal places using rounding mode rm, or ROUNDING_MODE if rm is omitted.
     *
     * Note: as with JavaScript's number type, (-0).toFixed(0) is '0',
     * but e.g. (-0.00001).toFixed(0) is '-0'.
     *
     * [dp] {number} Decimal places. Integer, 0 to MAX inclusive.
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {dp|rm}'
     */
    P.toFixed = function (dp, rm) {
      if (dp != null) {
        intCheck(dp, 0, MAX);
        dp = dp + this.e + 1;
      }
      return format(this, dp, rm);
    };


    /*
     * Return a string representing the value of this BigNumber in fixed-point notation rounded
     * using rm or ROUNDING_MODE to dp decimal places, and formatted according to the properties
     * of the format or FORMAT object (see BigNumber.set).
     *
     * The formatting object may contain some or all of the properties shown below.
     *
     * FORMAT = {
     *   prefix: '',
     *   groupSize: 3,
     *   secondaryGroupSize: 0,
     *   groupSeparator: ',',
     *   decimalSeparator: '.',
     *   fractionGroupSize: 0,
     *   fractionGroupSeparator: '\xA0',      // non-breaking space
     *   suffix: ''
     * };
     *
     * [dp] {number} Decimal places. Integer, 0 to MAX inclusive.
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     * [format] {object} Formatting options. See FORMAT pbject above.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {dp|rm}'
     * '[BigNumber Error] Argument not an object: {format}'
     */
    P.toFormat = function (dp, rm, format) {
      var str,
        x = this;

      if (format == null) {
        if (dp != null && rm && typeof rm == 'object') {
          format = rm;
          rm = null;
        } else if (dp && typeof dp == 'object') {
          format = dp;
          dp = rm = null;
        } else {
          format = FORMAT;
        }
      } else if (typeof format != 'object') {
        throw Error
          (bignumberError + 'Argument not an object: ' + format);
      }

      str = x.toFixed(dp, rm);

      if (x.c) {
        var i,
          arr = str.split('.'),
          g1 = +format.groupSize,
          g2 = +format.secondaryGroupSize,
          groupSeparator = format.groupSeparator || '',
          intPart = arr[0],
          fractionPart = arr[1],
          isNeg = x.s < 0,
          intDigits = isNeg ? intPart.slice(1) : intPart,
          len = intDigits.length;

        if (g2) i = g1, g1 = g2, g2 = i, len -= i;

        if (g1 > 0 && len > 0) {
          i = len % g1 || g1;
          intPart = intDigits.substr(0, i);
          for (; i < len; i += g1) intPart += groupSeparator + intDigits.substr(i, g1);
          if (g2 > 0) intPart += groupSeparator + intDigits.slice(i);
          if (isNeg) intPart = '-' + intPart;
        }

        str = fractionPart
         ? intPart + (format.decimalSeparator || '') + ((g2 = +format.fractionGroupSize)
          ? fractionPart.replace(new RegExp('\\d{' + g2 + '}\\B', 'g'),
           '$&' + (format.fractionGroupSeparator || ''))
          : fractionPart)
         : intPart;
      }

      return (format.prefix || '') + str + (format.suffix || '');
    };


    /*
     * Return an array of two BigNumbers representing the value of this BigNumber as a simple
     * fraction with an integer numerator and an integer denominator.
     * The denominator will be a positive non-zero value less than or equal to the specified
     * maximum denominator. If a maximum denominator is not specified, the denominator will be
     * the lowest value necessary to represent the number exactly.
     *
     * [md] {number|string|BigNumber} Integer >= 1, or Infinity. The maximum denominator.
     *
     * '[BigNumber Error] Argument {not an integer|out of range} : {md}'
     */
    P.toFraction = function (md) {
      var d, d0, d1, d2, e, exp, n, n0, n1, q, r, s,
        x = this,
        xc = x.c;

      if (md != null) {
        n = new BigNumber(md);

        // Throw if md is less than one or is not an integer, unless it is Infinity.
        if (!n.isInteger() && (n.c || n.s !== 1) || n.lt(ONE)) {
          throw Error
            (bignumberError + 'Argument ' +
              (n.isInteger() ? 'out of range: ' : 'not an integer: ') + valueOf(n));
        }
      }

      if (!xc) return new BigNumber(x);

      d = new BigNumber(ONE);
      n1 = d0 = new BigNumber(ONE);
      d1 = n0 = new BigNumber(ONE);
      s = coeffToString(xc);

      // Determine initial denominator.
      // d is a power of 10 and the minimum max denominator that specifies the value exactly.
      e = d.e = s.length - x.e - 1;
      d.c[0] = POWS_TEN[(exp = e % LOG_BASE) < 0 ? LOG_BASE + exp : exp];
      md = !md || n.comparedTo(d) > 0 ? (e > 0 ? d : n1) : n;

      exp = MAX_EXP;
      MAX_EXP = 1 / 0;
      n = new BigNumber(s);

      // n0 = d1 = 0
      n0.c[0] = 0;

      for (; ;)  {
        q = div(n, d, 0, 1);
        d2 = d0.plus(q.times(d1));
        if (d2.comparedTo(md) == 1) break;
        d0 = d1;
        d1 = d2;
        n1 = n0.plus(q.times(d2 = n1));
        n0 = d2;
        d = n.minus(q.times(d2 = d));
        n = d2;
      }

      d2 = div(md.minus(d0), d1, 0, 1);
      n0 = n0.plus(d2.times(n1));
      d0 = d0.plus(d2.times(d1));
      n0.s = n1.s = x.s;
      e = e * 2;

      // Determine which fraction is closer to x, n0/d0 or n1/d1
      r = div(n1, d1, e, ROUNDING_MODE).minus(x).abs().comparedTo(
          div(n0, d0, e, ROUNDING_MODE).minus(x).abs()) < 1 ? [n1, d1] : [n0, d0];

      MAX_EXP = exp;

      return r;
    };


    /*
     * Return the value of this BigNumber converted to a number primitive.
     */
    P.toNumber = function () {
      return +valueOf(this);
    };


    /*
     * Return a string representing the value of this BigNumber rounded to sd significant digits
     * using rounding mode rm or ROUNDING_MODE. If sd is less than the number of digits
     * necessary to represent the integer part of the value in fixed-point notation, then use
     * exponential notation.
     *
     * [sd] {number} Significant digits. Integer, 1 to MAX inclusive.
     * [rm] {number} Rounding mode. Integer, 0 to 8 inclusive.
     *
     * '[BigNumber Error] Argument {not a primitive number|not an integer|out of range}: {sd|rm}'
     */
    P.toPrecision = function (sd, rm) {
      if (sd != null) intCheck(sd, 1, MAX);
      return format(this, sd, rm, 2);
    };


    /*
     * Return a string representing the value of this BigNumber in base b, or base 10 if b is
     * omitted. If a base is specified, including base 10, round according to DECIMAL_PLACES and
     * ROUNDING_MODE. If a base is not specified, and this BigNumber has a positive exponent
     * that is equal to or greater than TO_EXP_POS, or a negative exponent equal to or less than
     * TO_EXP_NEG, return exponential notation.
     *
     * [b] {number} Integer, 2 to ALPHABET.length inclusive.
     *
     * '[BigNumber Error] Base {not a primitive number|not an integer|out of range}: {b}'
     */
    P.toString = function (b) {
      var str,
        n = this,
        s = n.s,
        e = n.e;

      // Infinity or NaN?
      if (e === null) {
        if (s) {
          str = 'Infinity';
          if (s < 0) str = '-' + str;
        } else {
          str = 'NaN';
        }
      } else {
        if (b == null) {
          str = e <= TO_EXP_NEG || e >= TO_EXP_POS
           ? toExponential(coeffToString(n.c), e)
           : toFixedPoint(coeffToString(n.c), e, '0');
        } else if (b === 10) {
          n = round(new BigNumber(n), DECIMAL_PLACES + e + 1, ROUNDING_MODE);
          str = toFixedPoint(coeffToString(n.c), n.e, '0');
        } else {
          intCheck(b, 2, ALPHABET.length, 'Base');
          str = convertBase(toFixedPoint(coeffToString(n.c), e, '0'), 10, b, s, true);
        }

        if (s < 0 && n.c[0]) str = '-' + str;
      }

      return str;
    };


    /*
     * Return as toString, but do not accept a base argument, and include the minus sign for
     * negative zero.
     */
    P.valueOf = P.toJSON = function () {
      return valueOf(this);
    };


    P._isBigNumber = true;

    if (configObject != null) BigNumber.set(configObject);

    return BigNumber;
  }


  // PRIVATE HELPER FUNCTIONS

  // These functions don't need access to variables,
  // e.g. DECIMAL_PLACES, in the scope of the `clone` function above.


  function bitFloor(n) {
    var i = n | 0;
    return n > 0 || n === i ? i : i - 1;
  }


  // Return a coefficient array as a string of base 10 digits.
  function coeffToString(a) {
    var s, z,
      i = 1,
      j = a.length,
      r = a[0] + '';

    for (; i < j;) {
      s = a[i++] + '';
      z = LOG_BASE - s.length;
      for (; z--; s = '0' + s);
      r += s;
    }

    // Determine trailing zeros.
    for (j = r.length; r.charCodeAt(--j) === 48;);

    return r.slice(0, j + 1 || 1);
  }


  // Compare the value of BigNumbers x and y.
  function compare(x, y) {
    var a, b,
      xc = x.c,
      yc = y.c,
      i = x.s,
      j = y.s,
      k = x.e,
      l = y.e;

    // Either NaN?
    if (!i || !j) return null;

    a = xc && !xc[0];
    b = yc && !yc[0];

    // Either zero?
    if (a || b) return a ? b ? 0 : -j : i;

    // Signs differ?
    if (i != j) return i;

    a = i < 0;
    b = k == l;

    // Either Infinity?
    if (!xc || !yc) return b ? 0 : !xc ^ a ? 1 : -1;

    // Compare exponents.
    if (!b) return k > l ^ a ? 1 : -1;

    j = (k = xc.length) < (l = yc.length) ? k : l;

    // Compare digit by digit.
    for (i = 0; i < j; i++) if (xc[i] != yc[i]) return xc[i] > yc[i] ^ a ? 1 : -1;

    // Compare lengths.
    return k == l ? 0 : k > l ^ a ? 1 : -1;
  }


  /*
   * Check that n is a primitive number, an integer, and in range, otherwise throw.
   */
  function intCheck(n, min, max, name) {
    if (n < min || n > max || n !== mathfloor(n)) {
      throw Error
       (bignumberError + (name || 'Argument') + (typeof n == 'number'
         ? n < min || n > max ? ' out of range: ' : ' not an integer: '
         : ' not a primitive number: ') + String(n));
    }
  }


  // Assumes finite n.
  function isOdd(n) {
    var k = n.c.length - 1;
    return bitFloor(n.e / LOG_BASE) == k && n.c[k] % 2 != 0;
  }


  function toExponential(str, e) {
    return (str.length > 1 ? str.charAt(0) + '.' + str.slice(1) : str) +
     (e < 0 ? 'e' : 'e+') + e;
  }


  function toFixedPoint(str, e, z) {
    var len, zs;

    // Negative exponent?
    if (e < 0) {

      // Prepend zeros.
      for (zs = z + '.'; ++e; zs += z);
      str = zs + str;

    // Positive exponent
    } else {
      len = str.length;

      // Append zeros.
      if (++e > len) {
        for (zs = z, e -= len; --e; zs += z);
        str += zs;
      } else if (e < len) {
        str = str.slice(0, e) + '.' + str.slice(e);
      }
    }

    return str;
  }


  // EXPORT


  BigNumber = clone();
  BigNumber['default'] = BigNumber.BigNumber = BigNumber;

  // AMD.
  if (typeof define == 'function' && define.amd) {
    define(function () { return BigNumber; });

  // Node.js and other environments that support module.exports.
  } else if (typeof module != 'undefined' && module.exports) {
    module.exports = BigNumber;

  // Browser.
  } else {
    if (!globalObject) {
      globalObject = typeof self != 'undefined' && self ? self : window;
    }

    globalObject.BigNumber = BigNumber;
  }
})(this);

},{}],3:[function(require,module,exports){
/*!
 * Extenso.js 2.0.1
 * © 2015-2019 Matheus Alves
 * License: MIT
 */
!function(e,n){"object"==typeof exports&&"object"==typeof module?module.exports=n():"function"==typeof define&&define.amd?define([],n):"object"==typeof exports?exports.extenso=n():e.extenso=n()}("undefined"!=typeof self?self:this,function(){return function(r){var t={};function a(e){if(t[e])return t[e].exports;var n=t[e]={i:e,l:!1,exports:{}};return r[e].call(n.exports,n,n.exports,a),n.l=!0,n.exports}return a.m=r,a.c=t,a.d=function(e,n,r){a.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:r})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(n,e){if(1&e&&(n=a(n)),8&e)return n;if(4&e&&"object"==typeof n&&n&&n.__esModule)return n;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var t in n)a.d(r,t,function(e){return n[e]}.bind(null,t));return r},a.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(n,"a",n),n},a.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},a.p="",a(a.s="./index.js")}({"./index.js":function(module,exports,__webpack_require__){eval('module.exports = __webpack_require__(/*! ./src/write-all */ "./src/write-all.js").default;\n\n//# sourceURL=webpack://extenso/./index.js?')},"./node_modules/@arr/reverse/module.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__["default"] = (function (arr) {\n  if (arr == null) {\n    return [];\n  }\n\n  var i = 0,\n      len = arr.length,\n      j = len - 1;\n  var k,\n      tmp,\n      mid = len / 2 | 0; // same as Math.floor\n\n  for (; i < mid; i++) {\n    tmp = arr[i];\n    k = j - i;\n    arr[i] = arr[k];\n    arr[k] = tmp;\n  }\n\n  return arr;\n});\n\n//# sourceURL=webpack://extenso/./node_modules/@arr/reverse/module.js?')},"./node_modules/assign-deep/index.js":function(module,exports,__webpack_require__){"use strict";eval("/*!\n * assign-deep <https://github.com/jonschlinkert/assign-deep>\n *\n * Copyright (c) 2017-present, Jon Schlinkert.\n * Released under the MIT License.\n */\n\n\nconst assignSymbols = __webpack_require__(/*! assign-symbols */ \"./node_modules/assign-deep/node_modules/assign-symbols/index.js\");\n\nconst toString = Object.prototype.toString;\n\nconst assign = module.exports = (target, ...args) => {\n  let i = 0;\n  if (isPrimitive(target)) target = args[i++];\n  if (!target) target = {};\n\n  for (; i < args.length; i++) {\n    if (isObject(args[i])) {\n      for (const key of Object.keys(args[i])) {\n        if (isObject(target[key]) && isObject(args[i][key])) {\n          assign(target[key], args[i][key]);\n        } else {\n          target[key] = args[i][key];\n        }\n      }\n\n      assignSymbols(target, args[i]);\n    }\n  }\n\n  return target;\n};\n\nfunction isObject(val) {\n  return typeof val === 'function' || toString.call(val) === '[object Object]';\n}\n\nfunction isPrimitive(val) {\n  return typeof val === 'object' ? val === null : typeof val !== 'function';\n}\n\n//# sourceURL=webpack://extenso/./node_modules/assign-deep/index.js?")},"./node_modules/assign-deep/node_modules/assign-symbols/index.js":function(module,exports,__webpack_require__){"use strict";eval("/*!\n * assign-symbols <https://github.com/jonschlinkert/assign-symbols>\n *\n * Copyright (c) 2015-present, Jon Schlinkert.\n * Licensed under the MIT License.\n */\n\n\nconst toString = Object.prototype.toString;\nconst isEnumerable = Object.prototype.propertyIsEnumerable;\nconst getSymbols = Object.getOwnPropertySymbols;\n\nmodule.exports = (target, ...args) => {\n  if (!isObject(target)) {\n    throw new TypeError('expected the first argument to be an object');\n  }\n\n  if (args.length === 0 || typeof Symbol !== 'function' || typeof getSymbols !== 'function') {\n    return target;\n  }\n\n  for (let arg of args) {\n    let names = getSymbols(arg);\n\n    for (let key of names) {\n      if (isEnumerable.call(arg, key)) {\n        target[key] = arg[key];\n      }\n    }\n  }\n\n  return target;\n};\n\nfunction isObject(val) {\n  return typeof val === 'function' || toString.call(val) === '[object Object]' || Array.isArray(val);\n}\n\n//# sourceURL=webpack://extenso/./node_modules/assign-deep/node_modules/assign-symbols/index.js?")},"./node_modules/format-number/index.js":function(module,exports){eval("module.exports = formatter;\nmodule.exports.default = formatter;\n\nfunction formatter(options) {\n  options = options || {}; // *********************************************************************************************\n  // Set defaults for negatives\n  // options.negative, options.negativeOut, options.separator retained for backward compatibility\n  // *********************************************************************************************\n  // type of negative; default left\n\n  options.negativeType = options.negativeType || (options.negative === 'R' ? 'right' : 'left'); // negative symbols '-' or '()'\n\n  if (typeof options.negativeLeftSymbol !== 'string') {\n    switch (options.negativeType) {\n      case 'left':\n        options.negativeLeftSymbol = '-';\n        break;\n\n      case 'brackets':\n        options.negativeLeftSymbol = '(';\n        break;\n\n      default:\n        options.negativeLeftSymbol = '';\n    }\n  }\n\n  if (typeof options.negativeRightSymbol !== 'string') {\n    switch (options.negativeType) {\n      case 'right':\n        options.negativeRightSymbol = '-';\n        break;\n\n      case 'brackets':\n        options.negativeRightSymbol = ')';\n        break;\n\n      default:\n        options.negativeRightSymbol = '';\n    }\n  } // whether negative symbol should be inside/outside prefix and suffix\n\n\n  if (typeof options.negativeLeftOut !== \"boolean\") {\n    options.negativeLeftOut = options.negativeOut === false ? false : true;\n  }\n\n  if (typeof options.negativeRightOut !== \"boolean\") {\n    options.negativeRightOut = options.negativeOut === false ? false : true;\n  } //prefix and suffix\n\n\n  options.prefix = options.prefix || '';\n  options.suffix = options.suffix || ''; //separators\n\n  if (typeof options.integerSeparator !== 'string') {\n    options.integerSeparator = typeof options.separator === 'string' ? options.separator : ',';\n  }\n\n  options.decimalsSeparator = typeof options.decimalsSeparator === 'string' ? options.decimalsSeparator : '';\n  options.decimal = options.decimal || '.'; //padders\n\n  options.padLeft = options.padLeft || -1; //default no padding\n\n  options.padRight = options.padRight || -1; //default no padding\n\n  function format(number, overrideOptions) {\n    overrideOptions = overrideOptions || {};\n\n    if (number || number === 0) {\n      number = '' + number; //convert number to string if it isn't already\n    } else {\n      return '';\n    } //identify a negative number and make it absolute\n\n\n    var output = [];\n    var negative = number.charAt(0) === '-';\n    number = number.replace(/^\\-/g, ''); //Prepare output with left hand negative and/or prefix\n\n    if (!options.negativeLeftOut && !overrideOptions.noUnits) {\n      output.push(options.prefix);\n    }\n\n    if (negative) {\n      output.push(options.negativeLeftSymbol);\n    }\n\n    if (options.negativeLeftOut && !overrideOptions.noUnits) {\n      output.push(options.prefix);\n    } //Format core number\n\n\n    number = number.split('.');\n    if (options.round != null) round(number, options.round);\n    if (options.truncate != null) number[1] = truncate(number[1], options.truncate);\n    if (options.padLeft > 0) number[0] = padLeft(number[0], options.padLeft);\n    if (options.padRight > 0) number[1] = padRight(number[1], options.padRight);\n    if (!overrideOptions.noSeparator && number[1]) number[1] = addDecimalSeparators(number[1], options.decimalsSeparator);\n    if (!overrideOptions.noSeparator && number[0]) number[0] = addIntegerSeparators(number[0], options.integerSeparator);\n    output.push(number[0]);\n\n    if (number[1]) {\n      output.push(options.decimal);\n      output.push(number[1]);\n    } //Prepare output with right hand negative and/or prefix\n\n\n    if (options.negativeRightOut && !overrideOptions.noUnits) {\n      output.push(options.suffix);\n    }\n\n    if (negative) {\n      output.push(options.negativeRightSymbol);\n    }\n\n    if (!options.negativeRightOut && !overrideOptions.noUnits) {\n      output.push(options.suffix);\n    } //join output and return\n\n\n    return output.join('');\n  }\n\n  format.negative = options.negative;\n  format.negativeOut = options.negativeOut;\n  format.negativeType = options.negativeType;\n  format.negativeLeftOut = options.negativeLeftOut;\n  format.negativeLeftSymbol = options.negativeLeftSymbol;\n  format.negativeRightOut = options.negativeRightOut;\n  format.negativeRightSymbol = options.negativeRightSymbol;\n  format.prefix = options.prefix;\n  format.suffix = options.suffix;\n  format.separate = options.separate;\n  format.integerSeparator = options.integerSeparator;\n  format.decimalsSeparator = options.decimalsSeparator;\n  format.decimal = options.decimal;\n  format.padLeft = options.padLeft;\n  format.padRight = options.padRight;\n  format.truncate = options.truncate;\n  format.round = options.round;\n\n  function unformat(number, allowedSeparators) {\n    allowedSeparators = allowedSeparators || [];\n\n    if (options.allowedSeparators) {\n      options.allowedSeparators.forEach(function (s) {\n        allowedSeparators.push(s);\n      });\n    }\n\n    allowedSeparators.push(options.integerSeparator);\n    allowedSeparators.push(options.decimalsSeparator);\n    number = number.replace(options.prefix, '');\n    number = number.replace(options.suffix, '');\n    var newNumber = number;\n\n    do {\n      number = newNumber;\n\n      for (var i = 0; i < allowedSeparators.length; i++) {\n        newNumber = newNumber.replace(allowedSeparators[i], '');\n      }\n    } while (newNumber != number);\n\n    return number;\n  }\n\n  format.unformat = unformat;\n\n  function validate(number, allowedSeparators) {\n    number = unformat(number, allowedSeparators);\n    number = number.split(options.decimal);\n\n    if (number.length > 2) {\n      return false;\n    } else if (options.truncate != null && number[1] && number[1].length > options.truncate) {\n      return false;\n    } else if (options.round != null && number[1] && number[1].length > options.round) {\n      return false;\n    } else {\n      return /^-?\\d+\\.?\\d*$/.test(number);\n    }\n  }\n\n  return format;\n} //where x is already the integer part of the number\n\n\nfunction addIntegerSeparators(x, separator) {\n  x += '';\n  if (!separator) return x;\n  var rgx = /(\\d+)(\\d{3})/;\n\n  while (rgx.test(x)) {\n    x = x.replace(rgx, '$1' + separator + '$2');\n  }\n\n  return x;\n} //where x is already the decimal part of the number\n\n\nfunction addDecimalSeparators(x, separator) {\n  x += '';\n  if (!separator) return x;\n  var rgx = /(\\d{3})(\\d+)/;\n\n  while (rgx.test(x)) {\n    x = x.replace(rgx, '$1' + separator + '$2');\n  }\n\n  return x;\n} //where x is the integer part of the number\n\n\nfunction padLeft(x, padding) {\n  x = x + '';\n  var buf = [];\n\n  while (buf.length + x.length < padding) {\n    buf.push('0');\n  }\n\n  return buf.join('') + x;\n} //where x is the decimals part of the number\n\n\nfunction padRight(x, padding) {\n  if (x) {\n    x += '';\n  } else {\n    x = '';\n  }\n\n  var buf = [];\n\n  while (buf.length + x.length < padding) {\n    buf.push('0');\n  }\n\n  return x + buf.join('');\n}\n\nfunction truncate(x, length) {\n  if (x) {\n    x += '';\n  }\n\n  if (x && x.length > length) {\n    return x.substr(0, length);\n  } else {\n    return x;\n  }\n} //where number is an array with 0th item as integer string and 1st item as decimal string (no negatives)\n\n\nfunction round(number, places) {\n  if (number[1] && places >= 0 && number[1].length > places) {\n    //truncate to correct number of decimal places\n    var decim = number[1].slice(0, places); //if next digit was >= 5 we need to round up\n\n    if (+number[1].substr(places, 1) >= 5) {\n      //But first count leading zeros as converting to a number will loose them\n      var leadingzeros = \"\";\n\n      while (decim.charAt(0) === \"0\") {\n        leadingzeros = leadingzeros + \"0\";\n        decim = decim.substr(1);\n      } //Then we can change decim to a number and add 1 before replacing leading zeros\n\n\n      decim = +decim + 1 + '';\n      decim = leadingzeros + decim;\n\n      if (decim.length > places) {\n        //adding one has made it longer\n        number[0] = +number[0] + +decim.charAt(0) + ''; //add value of firstchar to the integer part\n\n        decim = decim.substring(1); //ignore the 1st char at the beginning which is the carry to the integer part\n      }\n    }\n\n    number[1] = decim;\n  }\n\n  return number;\n}\n\n//# sourceURL=webpack://extenso/./node_modules/format-number/index.js?")},"./src/get-list.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"listLt10\", function() { return listLt10; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"listLt100\", function() { return listLt100; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"listLt1000\", function() { return listLt1000; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"listGt1000\", function() { return listGt1000; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"listDecimals\", function() { return listDecimals; });\n/**\r\n * Obter lista de números menores que dez.\r\n *\r\n * @method listLt10\r\n * @param {string} locale Código do país que deve ser escrito.\r\n * @returns {Array} Lista das partes do número.\r\n */\nvar listLt10 = function listLt10(locale) {\n  return ['zero', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];\n};\n/**\r\n * Obter lista de números menores que cem.\r\n *\r\n * @method listLt100\r\n * @param {string} locale Código do país que deve ser escrito.\r\n * @returns {Array} Lista das partes do número.\r\n */\n\nvar listLt100 = function listLt100(locale) {\n  return ['dez', 'onze', 'doze', 'treze', {\n    br: 'quatorze',\n    pt: 'catorze'\n  }[locale], 'quinze', {\n    br: 'dezesseis',\n    pt: 'dezasseis'\n  }[locale], {\n    br: 'dezessete',\n    pt: 'dezassete'\n  }[locale], 'dezoito', {\n    br: 'dezenove',\n    pt: 'dezanove'\n  }[locale], 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];\n};\n/**\r\n * Obter lista de números menores que mil.\r\n *\r\n * @method listLt1000\r\n * @param {string} locale Código do país que deve ser escrito.\r\n * @returns {Array} Lista das partes do número.\r\n */\n\nvar listLt1000 = function listLt1000(locale) {\n  return ['cento', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];\n};\n/**\r\n * Obter lista de números maiores que mil.\r\n *\r\n * @method listGt1000\r\n * @param {string} locale Código do país que deve ser escrito.\r\n * @returns {Array} Lista das partes do número.\r\n */\n\nvar listGt1000 = function listGt1000(locale) {\n  return ['mil', 'milhões', {\n    br: 'bilhões',\n    pt: 'biliões'\n  }[locale], {\n    br: 'trilhões',\n    pt: 'triliões'\n  }[locale], {\n    br: 'quatrilhões',\n    pt: 'quatriliões'\n  }[locale], {\n    br: 'quintilhões',\n    pt: 'quintiliões'\n  }[locale], {\n    br: 'sextilhões',\n    pt: 'sextiliões'\n  }[locale], {\n    br: 'septilhões',\n    pt: 'septiliões'\n  }[locale], {\n    br: 'octilhões',\n    pt: 'octiliões'\n  }[locale], {\n    br: 'nonilhões',\n    pt: 'noniliões'\n  }[locale], {\n    br: 'decilhões',\n    pt: 'deciliões'\n  }[locale], {\n    br: 'undecilhões',\n    pt: 'undeciliões'\n  }[locale], {\n    br: 'duodecilhões',\n    pt: 'duodeciliões'\n  }[locale]];\n};\n/**\r\n * Obter lista de números decimais.\r\n *\r\n * @method listDecimals\r\n * @param {string} locale Código do país que deve ser escrito.\r\n * @returns {Array} Lista das partes do número.\r\n */\n\nvar listDecimals = function listDecimals(locale) {\n  return ['milésimo', 'milionésimo', 'bilionésimo', 'trilionésimo', 'quatrilionésimo', 'quintilionésimo', 'sextilionésimo', 'septilionésimo', 'octilionésimo', 'nonilionésimo', 'decilionésimo', 'undecilionésimo', 'duodecilionésimo'];\n};\n\n//# sourceURL=webpack://extenso/./src/get-list.js?")},"./src/gt1000/index.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _int_util__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./int-util */ "./src/gt1000/int-util.js");\n/* harmony import */ var _parts_util__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./parts-util */ "./src/gt1000/parts-util.js");\n\n\n/**\r\n * Escrever números maiores que mil.\r\n *\r\n * @function gt1000\r\n * @param {string} int Número inteiro maior que mil.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {number} Valor escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (int, locale) {\n  var number = Object(_parts_util__WEBPACK_IMPORTED_MODULE_1__["write"])(Object(_parts_util__WEBPACK_IMPORTED_MODULE_1__["addComma"])(Object(_parts_util__WEBPACK_IMPORTED_MODULE_1__["addConjunction"])(Object(_parts_util__WEBPACK_IMPORTED_MODULE_1__["singularize"])(Object(_parts_util__WEBPACK_IMPORTED_MODULE_1__["clear"])(Object(_parts_util__WEBPACK_IMPORTED_MODULE_1__["name"])(Object(_int_util__WEBPACK_IMPORTED_MODULE_0__["split"])(int), locale))), int)), locale);\n  return number.join(\' \');\n});\n\n//# sourceURL=webpack://extenso/./src/gt1000/index.js?')},"./src/gt1000/int-util.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "split", function() { return split; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getLastNumber", function() { return getLastNumber; });\n/* harmony import */ var format_number__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! format-number */ "./node_modules/format-number/index.js");\n/* harmony import */ var format_number__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(format_number__WEBPACK_IMPORTED_MODULE_0__);\n\n/**\r\n * Separar um inteiro em uma array com base na formatação de um número.\r\n *\r\n * @method split\r\n * @param {string} int Número inteiro.\r\n * @returns {Array} Array com as partes do número.\r\n */\n\nvar split = function split(int) {\n  var format = format_number__WEBPACK_IMPORTED_MODULE_0___default()();\n  var formatted = format(int);\n  var splitted = formatted.split(\',\');\n  return splitted;\n};\n/**\r\n * Obter a última parte de um número.\r\n *\r\n * @method getLastNumber\r\n * @param {string} int Número inteiro.\r\n * @returns {number} Última parte do número.\r\n */\n\nvar getLastNumber = function getLastNumber(int) {\n  var splitted = split(int);\n  var last = splitted[splitted.length - 1];\n  var integer = parseInt(last);\n  return integer;\n};\n\n//# sourceURL=webpack://extenso/./src/gt1000/int-util.js?')},"./src/gt1000/parts-util.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addComma", function() { return addComma; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addConjunction", function() { return addConjunction; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "clear", function() { return clear; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "name", function() { return name; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "singularize", function() { return singularize; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "write", function() { return write; });\n/* harmony import */ var _arr_reverse__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @arr/reverse */ "./node_modules/@arr/reverse/module.js");\n/* harmony import */ var _int_util__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./int-util */ "./src/gt1000/int-util.js");\n/* harmony import */ var _get_list__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../get-list */ "./src/get-list.js");\n/* harmony import */ var _lt1000__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../lt1000 */ "./src/lt1000.js");\n\n\n\n\n/**\r\n * Adicionar vírgula entre algumas partes.\r\n *\r\n * @method addComma\r\n * @param {Array} parts Array com as partes.\r\n * @returns {Array} Partes com a vírgula caso tenho sido necessário.\r\n */\n\nvar addComma = function addComma(parts) {\n  return parts.map(function (part, index, array) {\n    // REGRA: Não adiciona entre a penúltima e a última parte.\n    return index < array.length - 2 ? "".concat(part, ",") : part;\n  });\n};\n/**\r\n * Adicionar conjunção "e" em determinadas partes.\r\n *\r\n * @method addConjunction\r\n * @param {Array} parts Partes do número que está sendo processado.\r\n * @param {string} int Número inteiro que está sendo processado.\r\n * @returns {Array} Partes com a conjução "e" caso tenha sido necessário.\r\n */\n\nvar addConjunction = function addConjunction(parts, int) {\n  var lastNum = Object(_int_util__WEBPACK_IMPORTED_MODULE_1__["getLastNumber"])(int); // A parte é valida apenas se:\n  // - Caso 1: A parte é um inteiro menor que cem.\n  // - Caso 2: A parte é um inteiro divisível por cem.\n\n  if (lastNum < 100 || lastNum % 100 === 0) {\n    return parts.map(function (part, index, array) {\n      return index === array.length - 2 ? "".concat(part, " e") : part;\n    });\n  }\n\n  return parts;\n};\n/**\r\n * Limpar partes que não são lidas no número.\r\n *\r\n * @method clear\r\n * @param {Array} parts Partes do número que está sendo processado.\r\n * @returns {Array} Partes com algumas partes removidas.\r\n */\n\nvar clear = function clear(parts) {\n  // Etapas para a remoção:\n  // - Etapa 1: Remove zeros à esquerda.\n  // - Etapa 2: Remove partes que não são lidas.\n  // - Etapa 3: Remove o "1" das partes com "1 mil".\n  return parts.map(function (part) {\n    return part.replace(/^0+\\s?/, \'\');\n  }).filter(function (part) {\n    return /^\\d/.test(part);\n  }).map(function (part) {\n    return part.replace(/^1\\s(mil)$/, \'$1\');\n  });\n};\n/**\r\n * Escrever por extenso os números inteiros dentro das partes.\r\n *\r\n * @method name\r\n * @param {Array} parts Partes do número que está sendo processado.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {Array} Partes com os inteiros escritos por extenso.\r\n */\n\nvar name = function name(parts, locale) {\n  return Object(_arr_reverse__WEBPACK_IMPORTED_MODULE_0__["default"])(Object(_arr_reverse__WEBPACK_IMPORTED_MODULE_0__["default"])(parts).map(function (part, i) {\n    var numberName = Object(_get_list__WEBPACK_IMPORTED_MODULE_2__["listGt1000"])(locale)[i - 1];\n    return numberName ? "".concat(part, " ").concat(numberName) : part;\n  }));\n};\n/**\r\n * Singularizar partes do número que são maiores que um.\r\n *\r\n * @method singularize\r\n * @param {Array} parts Partes do número que está sendo processado.\r\n * @returns {string} Número com as partes singularizadas.\r\n */\n\nvar singularize = function singularize(parts) {\n  var regex = /^(1\\s.*)ões/;\n\n  var replacer = function replacer(str) {\n    return str.replace(regex, \'$1ão\');\n  };\n\n  return parts.map(replacer);\n};\n/**\r\n * Deve escrever os inteiros restantes em uma array com as partes.\r\n *\r\n * @method write\r\n * @param {Array} parts Partes do número que está sendo processado.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {string} Número como todas as partes escritas por extenso.\r\n */\n\nvar write = function write(parts, locale) {\n  return parts.map(function (part) {\n    return part.replace(/^(\\d+)/, function (digit) {\n      var int = parseInt(digit);\n      return Object(_lt1000__WEBPACK_IMPORTED_MODULE_3__["default"])(int, locale);\n    });\n  });\n};\n\n//# sourceURL=webpack://extenso/./src/gt1000/parts-util.js?')},"./src/lt10.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _get_list__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./get-list */ "./src/get-list.js");\n\n/**\r\n * Obter um número inteiro menor que dez por extenso.\r\n *\r\n * @function lt10\r\n * @param {number} int Um número inteiro menor que dez.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {string} O número por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (int, locale) {\n  return Object(_get_list__WEBPACK_IMPORTED_MODULE_0__["listLt10"])(locale)[int];\n});\n\n//# sourceURL=webpack://extenso/./src/lt10.js?')},"./src/lt100.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _lt10__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lt10 */ "./src/lt10.js");\n/* harmony import */ var _get_list__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./get-list */ "./src/get-list.js");\n\n\n/**\r\n * Obter um número inteiro menor que cem por extenso.\r\n *\r\n * @function lt100\r\n * @param {number} int Um número inteiro menor que cem.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {string} O número escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (int, locale) {\n  if (int < 10) return Object(_lt10__WEBPACK_IMPORTED_MODULE_0__["default"])(int, locale);\n  if (int < 20) return Object(_get_list__WEBPACK_IMPORTED_MODULE_1__["listLt100"])(locale)[int - 10];\n  var unit = Object(_lt10__WEBPACK_IMPORTED_MODULE_0__["default"])(int % 10, locale);\n  var ten = Object(_get_list__WEBPACK_IMPORTED_MODULE_1__["listLt100"])(locale)[(int - int % 10) / 10 + 8];\n  return unit !== \'zero\' ? "".concat(ten, " e ").concat(unit) : ten;\n});\n\n//# sourceURL=webpack://extenso/./src/lt100.js?')},"./src/lt1000.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _get_list__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./get-list */ "./src/get-list.js");\n/* harmony import */ var _lt100__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lt100 */ "./src/lt100.js");\n\n\n/**\r\n * Obter um número inteiro menor que mil por extenso.\r\n *\r\n * @function lt1000\r\n * @param {number} int Um número inteiro menor que mil.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {string} Número escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (int, locale) {\n  if (int < 100) return Object(_lt100__WEBPACK_IMPORTED_MODULE_1__["default"])(int, locale);\n  if (int === 100) return \'cem\';\n  var hundredInt = int - int % 100;\n  var restInt = int % 100;\n  var hundred = Object(_get_list__WEBPACK_IMPORTED_MODULE_0__["listLt1000"])(locale)[hundredInt / 100 - 1];\n  var rest = Object(_lt100__WEBPACK_IMPORTED_MODULE_1__["default"])(restInt, locale);\n  return restInt ? "".concat(hundred, " e ").concat(rest) : hundred;\n});\n\n//# sourceURL=webpack://extenso/./src/lt1000.js?')},"./src/num-util.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"isValidNumber\", function() { return isValidNumber; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"parseNumber\", function() { return parseNumber; });\nfunction _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance\"); }\n\nfunction _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\n/**\r\n * Verificar se um valor é um número, da língua portuguesa, valido.\r\n *\r\n * @method isValidNumber\r\n * @param {string} val Um valor para ser verificado.\r\n * @returns {boolean} Verificação do valor.\r\n */\nvar isValidNumber = function isValidNumber(val) {\n  if (typeof val === 'number' && !Number.isSafeInteger(val)) {\n    return false;\n  } // Verifica se é um número\n\n\n  if (/^-?\\d{1,3}\\d?((\\.\\d{3})+)?$/.test(val) // ...formatado\n  || /^-?\\d{1,3}\\d?((\\.\\d{3})+)?,\\d+$/.test(val) // ...decimal formatado\n  || /^-?\\d+$/.test(val) // ...não formatado\n  || /^-?\\d+,\\d+/.test(val) // ...decimal não formatado\n  ) {\n      return true;\n    }\n\n  return false;\n};\n/**\r\n * Analisar um número.\r\n *\r\n * @method parseNumber\r\n * @param {string} val Um número para ser analisado\r\n * @returns {object} Objeto com as informações do número\r\n */\n\nvar parseNumber = function parseNumber(num) {\n  var isNegative = /^-/.test(num);\n  var normalized = num.replace(/(-|\\.)/g, '');\n\n  if (normalized.includes(',')) {\n    var _normalized$split$map = normalized.split(',').map(function (val) {\n      return val.replace(/^0+$/, '0');\n    }),\n        _normalized$split$map2 = _slicedToArray(_normalized$split$map, 2),\n        integer = _normalized$split$map2[0],\n        decimal = _normalized$split$map2[1];\n\n    return {\n      isNegative: isNegative,\n      integer: integer,\n      decimal: decimal\n    };\n  }\n\n  return {\n    isNegative: isNegative,\n    integer: normalized,\n    decimal: '0'\n  };\n};\n\n//# sourceURL=webpack://extenso/./src/num-util.js?")},"./src/write-all.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"isValidOpt\", function() { return isValidOpt; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"toNegative\", function() { return toNegative; });\n/* harmony import */ var assign_deep__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! assign-deep */ \"./node_modules/assign-deep/index.js\");\n/* harmony import */ var assign_deep__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(assign_deep__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _num_util__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./num-util */ \"./src/num-util.js\");\n/* harmony import */ var _write_currency__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./write-currency */ \"./src/write-currency/index.js\");\n/* harmony import */ var _write_decimal__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./write-decimal */ \"./src/write-decimal/index.js\");\n/* harmony import */ var _write_int__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./write-int */ \"./src/write-int.js\");\n\n\n\n\n\n/**\r\n * Verificar se uma opção é válida.\r\n *\r\n * @method isValidOpt\r\n * @param {string} val Valor da opção.\r\n * @param {Array} vals Valores para checagem.\r\n * @returns {boolean} Informação da validade da opção.\r\n */\n\nvar isValidOpt = function isValidOpt(val, vals) {\n  return vals.includes(val);\n};\n/**\r\n * Passar um número escrito por extenso para o modo negativo.\r\n *\r\n * @method toNegative\r\n * @param {string} num Valor escrito por extenso.\r\n * @param {string} [mode='formal'] Opção sobre o modo a ser escrito.\r\n * @returns {string} Valor como negativo.\r\n */\n\nvar toNegative = function toNegative(num) {\n  var mode = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'formal';\n  return mode === 'informal' ? \"menos \".concat(num) : \"\".concat(num, \" negativo\");\n};\n/**\r\n * Escrever números por extenso.\r\n *\r\n * @param {string|number} num Número para ser escrito por extenso.\r\n * @param {object} opts Opções para configurar modo de escrita.\r\n * @returns {string} Número escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (function (num, opts) {\n  if (typeof num !== 'string' && typeof num !== 'number') {\n    throw new TypeError('Must be a string or a number');\n  }\n\n  var numString = num.toString();\n\n  if (!Object(_num_util__WEBPACK_IMPORTED_MODULE_1__[\"isValidNumber\"])(numString)) {\n    throw new Error('Invalid number');\n  }\n\n  var defaultOpts = {\n    mode: 'number',\n    locale: 'br',\n    negative: 'formal',\n    currency: {\n      type: 'BRL'\n    },\n    number: {\n      gender: 'm',\n      decimal: 'formal'\n    } // Usando o pacote 'assign-deep' no lugar de Object.assign(),\n    // pois esse último substitui completamente todas as propriedades\n    // de um objeto que está dentro de outro objeto.\n\n  };\n  opts = assign_deep__WEBPACK_IMPORTED_MODULE_0___default()(defaultOpts, opts);\n\n  if (!isValidOpt(opts.mode, ['number', 'currency']) || !isValidOpt(opts.locale, ['pt', 'br']) || !isValidOpt(opts.negative, ['formal', 'informal']) || !isValidOpt(opts.currency.type, ['BRL', 'EUR']) || !isValidOpt(opts.number.gender, ['m', 'f']) || !isValidOpt(opts.number.decimal, ['formal', 'informal'])) {\n    throw new Error('Invalid option');\n  }\n\n  var _parseNumber = Object(_num_util__WEBPACK_IMPORTED_MODULE_1__[\"parseNumber\"])(numString),\n      isNegative = _parseNumber.isNegative,\n      integer = _parseNumber.integer,\n      decimal = _parseNumber.decimal;\n\n  if (opts.mode === 'currency') {\n    var iso = opts.currency.type;\n    var locale = opts.locale;\n    var numText = Object(_write_currency__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(iso, locale, integer, decimal);\n    return isNegative ? toNegative(numText, opts.negative) : numText;\n  }\n\n  if (opts.mode === 'number') {\n    var intNameSingular = opts.number.gender === 'f' ? 'inteira' : 'inteiro';\n    var intName = parseInt(integer) === 1 ? intNameSingular : \"\".concat(intNameSingular, \"s\");\n    var intText = Object(_write_int__WEBPACK_IMPORTED_MODULE_4__[\"default\"])(integer, opts.locale, opts.number.gender);\n    var decText = Object(_write_decimal__WEBPACK_IMPORTED_MODULE_3__[\"default\"])(decimal, opts.locale, opts.number.decimal); // Se tem a parte inteira e não tem a parte decimal\n\n    if (integer !== '0' && decimal === '0') {\n      return isNegative ? toNegative(intText, opts.negative) : intText;\n    } // Se não tem a parte inteira e tem a parte decimal\n\n\n    if (integer === '0' && decimal !== '0') {\n      var number = opts.number.decimal === 'informal' ? \"zero \".concat(decText) : decText;\n      return isNegative ? toNegative(number, opts.negative) : number;\n    } // Se tem a parte inteira e a parte decimal\n\n\n    if (integer !== '0' && decimal !== '0') {\n      if (opts.number.decimal === 'informal') {\n        return \"\".concat(intText, \" \").concat(decText);\n      }\n\n      var _numText = \"\".concat(intText, \" \").concat(intName, \" e \").concat(decText);\n\n      return isNegative ? toNegative(_numText, opts.negative) : _numText;\n    }\n  }\n});\n\n//# sourceURL=webpack://extenso/./src/write-all.js?")},"./src/write-currency/currencies.json":function(module){eval('module.exports = {"BRL":{"singular":"real","plural":"reais","subunit":{"singular":"centavo","plural":"centavos"}},"EUR":{"singular":"euro","plural":"euros","subunit":{"singular":"cêntimo","plural":"cêntimos"}}};\n\n//# sourceURL=webpack://extenso/./src/write-currency/currencies.json?')},"./src/write-currency/index.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getIsos", function() { return getIsos; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isValidIso", function() { return isValidIso; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isZero", function() { return isZero; });\n/* harmony import */ var _currencies_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./currencies.json */ "./src/write-currency/currencies.json");\nvar _currencies_json__WEBPACK_IMPORTED_MODULE_0___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./currencies.json */ "./src/write-currency/currencies.json", 1);\n/* harmony import */ var _write__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./write */ "./src/write-currency/write.js");\n/* harmony import */ var _write_subunit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./write-subunit */ "./src/write-currency/write-subunit.js");\n\n\n\n/**\r\n * Obter lista dos códigos ISO de um registro de moedas.\r\n *\r\n * @method getIsos\r\n * @param {object} currencies Objeto com registro de moedas.\r\n * @returns {Array} Lista com os códigos ISO.\r\n */\n\nvar getIsos = function getIsos(currencies) {\n  return Object.keys(currencies);\n};\n/**\r\n * Verificar se há um código ISO registrado.\r\n *\r\n * @method isValidIso\r\n * @param {string} iso Código ISO para ser verificado.\r\n * @param {object} currencies Objeto com registro de moedas.\r\n * @returns {boolean} Informação da existência do registro.\r\n */\n\nvar isValidIso = function isValidIso(iso, currencies) {\n  return getIsos(currencies).includes(iso);\n};\n/**\r\n * Verificar se um número, envolvido em string, é igual a zero.\r\n *\r\n * @method isZero\r\n * @param {string} val Número envolvido numa string.\r\n * @returns {boolean} Informação do valor.\r\n * @example\r\n * isZero(\'00\') // true\r\n * isZero(\'42\') // false\r\n */\n\nvar isZero = function isZero(val) {\n  return /^0+$/.test(val);\n};\n/**\r\n * Obter um valor monetário escrito por extenso.\r\n *\r\n * @method writeCurrency\r\n * @param {string} iso Código ISO da moeda que deverá ser usada.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @param {string} [unit=\'0\'] Valor da moeda (parte inteira).\r\n * @param {string} [subunit=\'0\'] Sub-unidade do valor (parte "decimal").\r\n * @returns {string} Valor escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (iso, locale) {\n  var unit = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : \'0\';\n  var subunit = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : \'0\';\n\n  if (!isValidIso(iso, _currencies_json__WEBPACK_IMPORTED_MODULE_0__)) {\n    throw new Error(\'Invalid ISO code\');\n  }\n\n  var opts = _currencies_json__WEBPACK_IMPORTED_MODULE_0__[iso];\n  var unitText = Object(_write__WEBPACK_IMPORTED_MODULE_1__["default"])(unit, locale, opts);\n  var subunitText = Object(_write_subunit__WEBPACK_IMPORTED_MODULE_2__["default"])(subunit, locale, opts);\n  if (isZero(unit)) return subunitText;\n  if (isZero(subunit)) return unitText;\n  if (isZero(unit) && isZero(subunit)) return "zero ".concat(opts.plural);\n  return "".concat(unitText, " e ").concat(subunitText);\n});\n\n//# sourceURL=webpack://extenso/./src/write-currency/index.js?')},"./src/write-currency/write-subunit.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _write_int__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../write-int */ "./src/write-int.js");\n\n/**\r\n * Obter a sub-unidade escrita por extenso.\r\n *\r\n * @method writeSubunit\r\n * @param {string} val Valor a ser escrito.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @param {object} opts Opções de escrita do valor.\r\n * @returns {string} Valor escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (val, locale, opts) {\n  var textNumber = Object(_write_int__WEBPACK_IMPORTED_MODULE_0__["default"])(val, locale);\n  return parseInt(val) === 1 ? "".concat(textNumber, " ").concat(opts.subunit.singular) : "".concat(textNumber, " ").concat(opts.subunit.plural);\n});\n\n//# sourceURL=webpack://extenso/./src/write-currency/write-subunit.js?')},"./src/write-currency/write.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _write_int__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../write-int */ "./src/write-int.js");\n\n/**\r\n * Obter o valor escrito por extenso.\r\n *\r\n * @method write\r\n * @param {string} val O valor a ser escrito.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @param {object} opts As opções de escrita do valor.\r\n * @returns {string} O valor escrito por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (val, locale, opts) {\n  var number = parseInt(val);\n  var text = Object(_write_int__WEBPACK_IMPORTED_MODULE_0__["default"])(val, locale);\n  if (number === 1) return "".concat(text, " ").concat(opts.singular);\n  if (number >= 1e+6) return "".concat(text, " de ").concat(opts.plural);\n  return "".concat(text, " ").concat(opts.plural);\n});\n\n//# sourceURL=webpack://extenso/./src/write-currency/write.js?')},"./src/write-decimal/index.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "pluralize", function() { return pluralize; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "writeDecimalFormal", function() { return writeDecimalFormal; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "writeDecimalInformal", function() { return writeDecimalInformal; });\n/* harmony import */ var _write_int__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../write-int */ "./src/write-int.js");\n/* harmony import */ var _get_list__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../get-list */ "./src/get-list.js");\n/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./util */ "./src/write-decimal/util.js");\n\n\n\n/**\r\n * Adicionar \'s\' nos finais de determinadas palavras - pluralizar.\r\n *\r\n * @method pluralize\r\n * @param {string} val Um substantivo.\r\n * @param {number} count A quantidade de objeto.\r\n * @returns {string} Palavra pluralizada.\r\n */\n\nvar pluralize = function pluralize(val, count) {\n  return count > 1 ? "".concat(val, "s") : val;\n};\n/**\r\n * Escrever formalmente a parte decimal de um número.\r\n *\r\n * @method writeDecimalFormal\r\n * @param {string} int Um número inteiro referente ao decimal.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {string} A parte decimal escrita por extenso.\r\n */\n\nvar writeDecimalFormal = function writeDecimalFormal(int, locale) {\n  // Veja <https://bit.ly/2SrsXVO> (no <archive.org>) para entender tudo.\n  var len = int.length;\n  var intNum = parseInt(int);\n  var intNormalized = int.replace(/^0+/, \'\');\n  var intText = Object(_write_int__WEBPACK_IMPORTED_MODULE_0__["default"])(intNormalized, locale);\n  var intType = pluralize(Object(_util__WEBPACK_IMPORTED_MODULE_2__["getType"])(len), intNum);\n  var intTypeOf = Object(_get_list__WEBPACK_IMPORTED_MODULE_1__["listDecimals"])(locale)[Math.floor(len / 3 - 1)];\n  if (len < 3) return "".concat(intText, " ").concat(intType);\n  if (len % 3 === 0) return "".concat(intText, " ").concat(pluralize(intTypeOf, intNum));\n  return "".concat(intText, " ").concat(intType, " de ").concat(intTypeOf);\n};\n/**\r\n * Escrever informalmente a parte decimal de um número.\r\n *\r\n * @method writeDecimalInformal\r\n * @param {string} int Um número inteiro referente ao decimal.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @returns {string} A parte decimal escrita por extenso.\r\n */\n\nvar writeDecimalInformal = function writeDecimalInformal(int, locale) {\n  return "v\\xEDrgula ".concat(Object(_write_int__WEBPACK_IMPORTED_MODULE_0__["default"])(int, locale));\n};\n/**\r\n * Escrever a parte decimal de um número por extenso.\r\n *\r\n * @method writeDecimal\r\n * @param {string} int Um número inteiro referente ao decimal.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @param {string} opt Opção informando se é \'formal\' ou \'informal\'.\r\n * @returns {string} A parte decimal escrita por extenso.\r\n */\n\n/* harmony default export */ __webpack_exports__["default"] = (function (int, locale, opt) {\n  return opt && opt === \'informal\' ? writeDecimalInformal(int, locale) : writeDecimalFormal(int, locale);\n});\n\n//# sourceURL=webpack://extenso/./src/write-decimal/index.js?')},"./src/write-decimal/util.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"getType\", function() { return getType; });\n/**\r\n * Obter a informação do tipo da casa decimal (décimo ou centésimo).\r\n *\r\n * @method getType\r\n * @param {number} place O número de casas do valor decimal.\r\n * @returns {string} Informação do tipo da casa.\r\n */\nvar getType = function getType(place) {\n  switch (place % 3) {\n    case 1:\n      return 'décimo';\n      break;\n\n    case 2:\n      return 'centésimo';\n      break;\n  }\n};\n\n//# sourceURL=webpack://extenso/./src/write-decimal/util.js?")},"./src/write-int.js":function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"toFemale\", function() { return toFemale; });\n/* harmony import */ var _lt1000__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lt1000 */ \"./src/lt1000.js\");\n/* harmony import */ var _gt1000__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./gt1000 */ \"./src/gt1000/index.js\");\n\n\n/**\r\n * Passar para o feminino alguns números.\r\n *\r\n * @method toFemale\r\n * @param {string} num Um número qualquer.\r\n * @returns {string} O número com algumas partes no feminino.\r\n * @example\r\n * toFemale('quarenta e dois')\r\n * // 'quarenta e duas'\r\n */\n\nvar toFemale = function toFemale(num) {\n  return num.replace(/\\bum\\b/, 'uma').replace(/\\bdois\\b/, 'duas');\n};\n/**\r\n * Obter qualquer número escrito por extenso.\r\n *\r\n * @method writeInt\r\n * @param {string} int Um número para ser escrito.\r\n * @param {string} locale Código do país para escrever o número.\r\n * @param {string} [gender='m'] A opção do gênero do número.\r\n * @returns {string} O número escrito.\r\n */\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (function (int, locale) {\n  var gender = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'm';\n  var intNum = parseInt(int);\n  var num;\n  if (intNum < 1000) num = Object(_lt1000__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(intNum, locale);\n  if (intNum === 1000) num = 'mil';\n  if (intNum > 1000) num = Object(_gt1000__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(int, locale);\n  return gender === 'f' ? toFemale(num) : num;\n});\n\n//# sourceURL=webpack://extenso/./src/write-int.js?")}})});
},{}]},{},[1]);
