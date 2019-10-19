function show_table(str) {

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    document.getElementById("d-dyn").innerHTML = this.responseText;
	  }
	};
	xmlhttp.open("GET", "../load_table.php/?id=1&q=" + str, true);
	xmlhttp.send();
}

function tn_menu_selector() {
	var row = document.getElementById("t-list").getElementsByTagName("tr");

	for (var i = 1; i < row.length; i++) {
		row[i].addEventListener("click", function() {
			var current = document.getElementsByClassName("active");
			current[0].className = current[0].className.replace(" active", "");
			this.className += " active";
			show_table(this.firstChild.innerHTML.substring(6));
		});
		
	}

}
