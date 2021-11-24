<!DOCTYPE html>

<head>
  <title>test2</title>
</head>

<body>
  <h1>Test2 - Документ </h1>

<?php

$myId = htmlspecialchars($_GET["myId"]);
if (!is_null($myId)){
echo 'Получен идентификатор для передачи данных, ' . $myId . '!';

$s2=<<<EOT
<script type="text/javascript">

window.myId="$myId";

function sendMessage(message) {
  window.opener.postMessage("message from tes2:"+message, "*");
}

function sendForm() {
// создать объект для формы
var formData = new FormData(document.forms.myData);

// добавить к пересылке ещё пару ключ - значение
formData.append("source", "Test2Javascript");

// отослать
var xhr = new XMLHttpRequest();
xhr.open("POST", "http://test1.gorodperm.ru/action.php");
sendMessage(' --- Test2 start sending data ');
xhr.onreadystatechange = function() {//Вызывает функцию при смене состояния.
  if(xhr.readyState == XMLHttpRequest.DONE) {
  if( xhr.status == 200) {
      // Запрос завершён. Здесь можно обрабатывать результат.
      sendMessage(' === Test2 send data is success and finished!');
  } else {
      console.log(xhr);
      sendMessage(' !!! Test2 send data error');
  }
 }
}

xhr.send(formData);

}


window.addEventListener("message", function(event) {
  if (event.origin != 'http://test1.gorodperm.ru') {
    // something from an unknown domain, let's ignore it
    return;
  }

    // alert( "received TEST2: " + event.data );
    newDiv = document.createElement("div");
    newDiv.innerHTML = "received on test2: " + event.data;
    document.body.appendChild(newDiv);

    // can message back using event.source.postMessage(...)
  });

  window.onload=function(){ sendMessage('Test2 is ready - dom Loaded!');  }
  window.onbeforeunload=function(){ sendMessage('Test2 is closed!!! need to reload!');  }

</script>
EOT;
    echo $s2;

    } else {
      echo ' Идентификатор не получен передача данных невозможна! ';
    }
?> 


  <div id="mainDiv">

    <form action="http://test1.gorodperm.ru/action.php" method="post" name="myData">
      <p>ID: <input name="myId" type="text" value="<?php  echo $_GET["myId"] ?>" readonly /> </p>
      <p>Sign:<textarea name="mySign" cols="20" name="comments" rows="3">Sign value for id <?php  $_GET["myId"] ?></textarea></p>
      <p>File PDF<input name="myFile" type="file"></p>
      <p><input type="submit" value="отправить" onclick="sendForm(); return false;" /> </p>
    </form>

    <input type=button onclick="sendMessage('Button click!!! from test2'); return false;" value="Message to test1"/>

    

    <script type="text/javascript">
      // set domain
      document.domain = 'gorodperm.ru';
    </script>

  </div>
</body>

</html>