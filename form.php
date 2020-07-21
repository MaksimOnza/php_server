<?php
    function check_param($out_param){
      foreach($_GET['parameters'] as $element){
        if($element==$out_param){
          return true;
        }
      }
      return false;
    }

    function html_input($name, $type='text'){
      return '<input type="'.$type.'" value="'.$_GET[$name].'" name="'.$name.'">';
  }

  function html_select($name, $options){
      $row = '';
      foreach($options as $value){
        $select = '';
        if($_GET[$name]==$value){
            $select = 'selected';
        }
        $row .= '<option value="'.$value.'" '.$select.'>'.$value.'</option>';
        $select = '';
      }
      return '<select name="'.$name.'">'.$row.'</select>';
  }


?>
<form>
    <h4>Enter the city:</h4>
    <?= html_input('city') ?><Br>
        <h3 >Select a resource API</h3>
        <?= html_select('resources', [
            'openweathermap',
            'weatherstack',
            'worldweatheronline'
        ]) ?>

      <p>Select a parameters:</p>

     <p><input type="checkbox" name="parameters[]" value="wind" <?php echo check_param('wind')?'checked':'' ?>> wind</p>
     <p><input type="checkbox" name="parameters[]" value="pres" <?php echo check_param('pres')?'checked':'' ?>> pressure</p>
     <p><input type="checkbox" name="parameters[]" value="temp" <?php echo check_param('temp')?'checked':'' ?>> temperature</p>
     <p><input type="checkbox" name="parameters[]" value="desc" <?php echo check_param('desc')?'checked':'' ?>> description</p>
     <p><input type="checkbox" name="function_json2" value="true" > function get_json2()</p>
     <p><input type="submit" value="Get the weather"></p>
  </form>
  <form action="display_table.php" method="GET">
    <input type="submit" value="Display in table">
  </form>
   
   <?php 
      check_param('pres');
      ?>
</body>
</html>




input функция для чекбоксов.
выбор параметров доделать.
выод результата через JS alert.
