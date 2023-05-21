<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>backend3</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>
  <div class="main">
  <h1>Форма</h1>
  
  <form action="" method="POST">
    <label>Ваше Имя:</label>
    <br>
    <input name="fio" />
    <br>
    <label>Еmail:</label>
    <input name="email" />
    <br>
    <label>Год рождения:</label>
    <br>
    <select name="year">
      <?php 
        for ($i = 1922; $i <= 2022; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
        }
      ?>
    </select>
    <label>Пол:</label>
    <br>
    <label><input name="gender" type="radio" value="w" />Женский</label>
    <label><input name="gender" type="radio" value="m" />Мужской</label>
    <br>
    <label>Количество конечностей:</label>
    <br>
    <label>1<input name="limbs" type="radio" value="1" /></label><br>
    <label>2<input name="limbs" type="radio" value="2" /></label><br>
    <label>3<input name="limbs" type="radio" value="3" /></label><br>
    <label>4<input name="limbs" type="radio" value="4" /></label>
    <br>
    <label>Сверхспособности</label>
    <br>
    <select name="ability[]" multiple="multiple">
      <option value="1" selected="selected">none</option>
      <option value="2" >Бессмертие</option>
      <option value="3" >Прохождения сквозь стены</option>
      <option value="4" >Левитация</option>
    </select>  
    <br>
    <label>Биография:</label>
    <br>
    <input name="biography" type="textarea">
    <br>
    <label>Отправить  </label>
    <input type="submit" value="ok" />
  </form>
  </div>
</body>
