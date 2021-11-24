<!DOCTYPE html>
<head>
  <title>test1 - МОЗ</title>
</head>

<body>
  <h1>Test1 - МОЗ</h1>
<?php


$myId = htmlspecialchars($_GET["myId"]) ?: "MOZdefaultID ";


if (!file_exists($myId)) {
    echo "<table style='width: 100%;	border: 1px solid #000; margin: 10px;'>	<tr>
		<td>Данных нет</td>
</tr></table>
";       
} else {
    $myfile = file_get_contents(join(DIRECTORY_SEPARATOR, array($myId, 'myFile')));
    $mySign = file_get_contents(join(DIRECTORY_SEPARATOR, array($myId, 'mySign')));


    echo "
<table style='width: 100%;	border: 1px solid #000; margin: 10px;'>	<tr>
		<td>$myId</td>
		<td>$myfile</td>
		<td>$mySign</td>
	</tr>
</table>
";
}
?>


    <input type="text" value="<?php echo $myId; ?>" id="myId">
    <button onclick="openPopup(document.getElementById('myId').value); return false;">Open popup 2 -> Document</button>
	<button onclick=" popupMess('Action1'); return false;">Action1 to popup!</button>
	<button onclick=" popupMess('Action2'); return false;">Action2 to popup!</button>
	<button onclick=" gotoUrl(document.getElementById('myId').value); return false;">Refresh with id!</button>



	<script type="text/javascript">
        // set domain
	    document.domain = 'gorodperm.ru';

		var windowObjectReference = null; // global variable

		function popupMess(action) {
			windowObjectReference.postMessage("Message from test1 to test2!"+action, "http://test2.gorodperm.ru")
		}

		window.addEventListener("message", function(event) {
			if (event.origin != 'http://test2.gorodperm.ru') {
				// something from an unknown domain, let's ignore it
				return;
			}
			newDiv = document.createElement("div");
            newDiv.innerHTML = "received test1: " + event.data;
			document.body.appendChild(newDiv);
			// can message back using event.source.postMessage(...)
		});

		function gotoUrl(id) {
			const myUrl = new URL(window.location.origin+window.location.pathname);

			myUrl.searchParams.append("myId", id);

			console.log(myUrl.href);
			window.location.assign(myUrl);
		};

		function openPopup(myId) {
		  if(windowObjectReference == null || windowObjectReference.closed)
		  /* if the pointer to the window object in memory does not exist
		     or if such pointer exists but the window was closed */

		  {
		    windowObjectReference = window.open("http://test2.gorodperm.ru/index.php?myId="+myId,
		   "Test2", "popup");
		   windowObjectReference.onload = () => { alert('Booyah ! ')}

		    /* then create it. The new window will be created and
		       will be brought on top of any other window. */
			
			windowObjectReference.postMessage("hello from test1 to test2!", "http://test2.gorodperm.ru")
		  }
		  else
		  {
		    windowObjectReference.focus();
		    /* else the window reference must exist and the window
		       is not closed; therefore, we can bring it back on top of any other
		       window with the focus() method. There would be no need to re-create
		       the window or to reload the referenced resource. */
		  };
		}
	</script>
</body>
</html>
