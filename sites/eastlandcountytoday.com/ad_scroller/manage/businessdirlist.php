<html>
<head><title>Interlink Main</title>
	<link rel="stylesheet" type="text/css" href="businessdir.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<SCRIPT language="javascript">

	$(function(){

		// add multiple select / deselect functionality
		$("#selectall").click(function () {
			$('.case').attr('checked', this.checked);
		});

		// if all checkbox are selected, check the selectall checkbox
		// and viceversa
		$(".case").click(function(){

			if($(".case").length == $(".case:checked").length) {
				$("#selectall").attr("checked", "checked");
			} else {
				$("#selectall").removeAttr("checked");
			}

		});
	});

	</SCRIPT>
</head>

<body>

	<table width="100%" border="0" align="center">

		<tr>
			<td valign="top" width="100%">
				<table width="100%" border="0">
					<tr>
						<td colspan="2" class="titles">&nbsp;&nbsp;<input type="checkbox" id="selectall"/>&nbsp;Select All
							<p class="titles">
							<?php echo $listFiles; ?>
							</p>
						</td>
					</tr>

				</table>
			</td>
		</tr>

	</table>

</body>
</html>
