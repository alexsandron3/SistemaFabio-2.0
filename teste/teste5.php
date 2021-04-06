<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>Document</title>
</head>

<body>
    <ul class="sortable" id="list-A">
        <li id="1">Value 1 </li>
        <li id="2">Value 2 </li>
        <li id="3">Value 3 </li>
    </ul>

    <ul class="sortable" id="list-B">
        <li id="4">Value 1 </li>
        <li id="5">Value 2 </li>
        <li id="6">Value 3 </li>
    </ul>
</body>
<script>
    $( ".sortable" ).sortable({
        connectWith: '.sortable',
        placeholder: "widget-highlight",
        // Receive callback
        receive: function(event, ui) {
          // The position where the new item was dropped
          var newIndex = ui.item.index();
          // Do some ajax action...
          $.post('someurl.php', {newPosition: newIndex}, function(returnVal) {
             // Stuff to do on AJAX post success
          });
        },
        // Likewise, use the .remove event to *delete* the item from its origin list
        remove: function(event, ui) {
          var oldIndex = ui.item.index();
          $.post('someurl.php', {deletedPosition: oldIndex}, function(returnVal) {
             // Stuff to do on AJAX post success
          });
     
        }
      });

</script>

</html>