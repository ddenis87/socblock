<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<h3>Данные по гражданину</h3>
<form action="ocenka_get.php" method="POST">
<table><tr><td>
  <label for="online_snils">СНИЛС:</label>
	<input id="online_snils" name="snils" type="text" maxlength="15"
         autofocus="autofocus" required="required"
         value="<?=(isset($_POST['snils'])?$_POST['snils']:'___-___-___ __')?>"
         pattern="[0-9]{3}[-][0-9]{3}[-][0-9]{3}[\s][0-9]{2}"
		 placeholder="___-___-___ __">
	<input type="submit" value="Поиск">
	</td><td>
</form>
<br>

<script type="text/javascript">
  function setCursorPosition(pos, e) {
    e.focus();
    if (e.setSelectionRange) e.setSelectionRange(pos, pos);
    else if (e.createTextRange) {
      var range = e.createTextRange();
      range.collapse(true);
      range.moveEnd("character", pos);
      range.moveStart("character", pos);
      range.select()
    }
  }

  function mask(e) {
    var matrix = this.placeholder,// .defaultValue
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, "");
    def.length >= val.length && (val = def);
    matrix = matrix.replace(/[_\d]/g, function(a) {
      return val.charAt(i++) || "_"
    });
    this.value = matrix;
    i = matrix.lastIndexOf(val.substr(-1));
    i < matrix.length && matrix != this.placeholder ? i++ : i = matrix.indexOf("_");
    setCursorPosition(i, this)
  }
  window.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#online_snils");
    input.addEventListener("input", mask, false);
    input.focus();
    setCursorPosition(3, input);
  });
</script>

</body>
</html>