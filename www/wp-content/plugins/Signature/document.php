<html>
<head><title>Sample - PDF Document Signing</title>
<script language="javascript" type="text/javascript">
	document.oncontextmenu = new Function("return false;");
</script>
<script type="text/javascript" src="wz_jsgraphics.js"></script> <!-- if you need windows mobile support -->
<script type="text/javascript" src="ss.js"></script>
</head>
<body>
    <form method="post" action="confirmation.php">
    <center><img src="affidavit.gif" />
		<div onclick="ShowSignModal();" id="divSign">
			<b>&nbsp;&nbsp;Click To Sign</b>
	    </div>
	</center>
	<table id="overlay">
		<tr>
			<td>
				<center>
				<div id='ctlSignature_Container' style='width:400px;height:270px;margin:20px'>
			    <?php
					$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false; 
					if ($msie == true) {
			            echo "<div ID='ctlSignature' style='width:400px;height:250px;border:Dashed 2px #DDDDDD'></div>";
					} else {
			    		echo "<canvas ID='ctlSignature' width='400' height='250'></canvas>";
			  		}
			    ?>
			    </div>
                </center>
              </td>
            </tr>
            <tr>
              <td>
              	<center>
              		<input type="submit" name="btnSave" value="Save" onclick="javascript:return ValidateSignature();" id="btnSave" class="save" />&nbsp;
                	<input type="button" id="btnCancel" class="cancel" onclick="ShowSignModal();" value="Cancel" />
                </center>
              </td>
            </tr>
         </table>
</form>
<script type="text/javascript">
	var signObjects = new Array('ctlSignature');
	var objctlSignature = new SuperSignature({SignObject:"ctlSignature",SignWidth: "400",SignHeight: "250",PenColor: "#DCDCDC",BorderStyle: "Dashed",BorderWidth: "2px",BorderColor: "#DDDDDD",RequiredPoints: "25",ClearImage:"refresh.png", PenCursor:"pencil.cur", Visible: "true"});		
	objctlSignature.Init();
   </script>
    <script language="javascript">
        function ShowSignModal() {
            el = document.getElementById("overlay");
            el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
            
            el2 = document.getElementById("divSign");
            el2.style.display = (el2.style.display == "") ? "none" : "";

            if (el.style.visibility == "visible") {
                document.body.style.backgroundColor = "#DDDDDD";
                document.getElementById("btnSave").focus();
            }
            else
            {
                document.body.style.backgroundColor = "#FFFFFF";
            }
        }
    </script>
</body>
</html>
