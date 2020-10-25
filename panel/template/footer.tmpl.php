	<footer class="footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">Arkei Stealer v9.1.2 | Develop by foxovsky</div>
			</div>
		</div>
	</footer>
	
	<script src="js/vendor.min.js"></script>
	<script src="js/app.min.js"></script>
	<script src="js/vendor/toastr.min.js"></script>
	<script src="js/pages/toastr.init.js"></script>
	
	<script>
	function UpdateComment(log_id)
	{
		var newComment = document.getElementById("new_comment" + log_id).value;
		
		var xhr = new XMLHttpRequest();

		xhr.open('GET', 'dashboard.php?req=update_comment&id='+ log_id +'&comment=' + newComment);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200 && xhr.responseText == "success")
			{
				toastr["success"]("Successful update comment");
			}
			else
			{
				toastr["error"]("Request failed.");
			}
		};
		xhr.send(encodeURI('name'));
	}
	
	function SetChecked(log_id)
	{
		var xhr = new XMLHttpRequest();

		xhr.open('GET', 'dashboard.php?req=set_checked&id='+ log_id);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200 && xhr.responseText == "success")
			{
				toastr["success"]("Successful update status");
			}
			else
			{
				toastr["error"]("Request failed.");
			}
		};
		xhr.send(encodeURI('name'));
	}
	
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-bottom-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	
	function DeleteLogs()
	{
		var logs = "";
		var checkboxes = document.getElementsByClassName('checkbox');
		var checkboxesChecked = [];
		for (var index = 0; index < checkboxes.length; index++)
		{
			 if (checkboxes[index].checked)
			 {
				checkboxesChecked.push(checkboxes[index].value);
				logs = logs + "" + checkboxes[index].value + ",";
			 }
		  }
		  
		  var xhr = new XMLHttpRequest();

		  xhr.open('GET', 'dashboard.php?action=delete_logs&ids='+ logs);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200 && xhr.responseText == "success")
			{
				toastr["success"]("Successful delete selected logs");
			}
			else
			{
				toastr["error"]("Request failed.");
			}
		};
		xhr.send(encodeURI('name'));
	}
	
	function SelectAll(source)
	{
		var checkboxes = document.getElementsByClassName('checkbox');
		
		for (var index = 0; index < checkboxes.length; index++)
		{
			checkboxes[index].checked = true;
		}
	}
	
	function UnselectAll(source)
	{
		var checkboxes = document.getElementsByClassName('checkbox');
		
		for (var index = 0; index < checkboxes.length; index++)
		{
			checkboxes[index].checked = false;
		}
	}
	
	</script>

	
</body>
</html>