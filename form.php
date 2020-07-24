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

  function html_checkbox($value_parameter){
    $empty_row = '';
    $checked_row = 'checked';
    $row = '<input type="checkbox" name="parameters[]" value="'.$value_parameter.'"';
    $checked = check_param($value_parameter)?$checked_row:$empty_row;
    return $row.' '.$checked.'>';
  }


?>
<form action="index.php" method="GET">
  <h4>Enter the city:</h4>
  <?= html_input('city') ?><Br>
      <h3 >Select a resource API</h3>
      <?= html_select('resources', [
          'openweathermap',
          'weatherstack',
          'worldweatheronline'
      ]) ?>

    <p>Select a parameters:</p>

   <p><?= html_checkbox('wind') ?> wind</p>
   <p><?= html_checkbox('pres') ?> pressure</p>
   <p><?= html_checkbox('temp') ?> temperature</p>
   <p><?= html_checkbox('desc') ?> description</p>
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




<!-- input функция для чекбоксов.
выбор параметров доделать.
вывод результата через JS alert. -->