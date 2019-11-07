console.log("script loaded!");

function init_sys_menu() {
	var dbIns = document.getElementById('inspector-module');
	var dBase = document.getElementById('database');
	var qry = document.getElementById('query-module');

	if (dbIns) dbIns.style.display = 'none';
	if (dBase) dBase.style.display = 'none';
	if (qry) qry.style.display = 'none';
}

function list_response(id, next) {
	var menu = document.getElementById(id);
	var options = menu.children;

	for (var i = 0; i < options.length; i++) {
		options[i].addEventListener("click", function() {
			menu = document.getElementById(id);
			var current = menu.getElementsByClassName("active")[0];
			if(current != null){
				current.className = current.className.replace(" active", "");
			}

			this.className += " active";
			if(next == null) {
				var dBase = document.getElementById('database');
				var qry = document.getElementById('query');
				var qryResults = document.getElementById('query-result');
				menu.parentElement.parentElement.parentElement.className = "wrapper-1 scalable";
				if(dBase) dBase.style.display = null;
				if(qry) qry.style.display = null;
				if(qryResults) qryResults.style.display = null;
				app_refresh('db', 'db-content', 't', this.innerHTML, 'db', 'dev_testing_environment');
			}
		});
	}

	if(next != null) {
		menu.parentElement.nextElementSibling.addEventListener("click", function() {
			this.parentElement.style.display = 'none';
			menu = document.getElementById(next);
			document.getElementById('database').style.display = 'none';
			menu.parentElement.style.display = null;
			menu.style.display = null;

			var x = document.getElementById('k-db');
			x.firstElementChild.firstElementChild.className = x.firstElementChild.firstElementChild.className.substr(0,14);
			x.firstElementChild.nextElementSibling.nextElementSibling.className = x.firstElementChild.nextElementSibling.nextElementSibling.className.substr(0,13);
			x.nextElementSibling.firstElementChild.firstElementChild.className += " db-active";
			x.nextElementSibling.firstElementChild.nextElementSibling.nextElementSibling.className += ' dl-active';
			app_refresh('t', 'select-t', 'db', this.previousElementSibling.firstElementChild.getElementsByClassName('active')[0].innerHTML, null, null);
			document.getElementById('db-content').innerHTML = "";
			list_response('select-t', null);
		});
	}
}

function display_menu_response() {
	var options = document.getElementsByClassName("display-pair");
	for (var i = 0; i < options.length; i++) {
		options[i].firstElementChild.addEventListener("click", function() {
			if(this.firstElementChild.className.includes('db-active', 1)){
				
				if(this.parentElement.id != null) {
					var p = pipeline(this.parentElement.id);
					if(p != null) {
						this.firstElementChild.className = this.firstElementChild.className.substr(0,14);
						this.nextElementSibling.nextElementSibling.className = this.nextElementSibling.nextElementSibling.className.substr(0,13);
						p.style.display = 'none';
					}
				}
			}else {
				var p = pipeline(this.parentElement.id);
				if(p != null) {
					this.firstElementChild.className += " db-active";
					this.nextElementSibling.nextElementSibling.className += ' dl-active';
					p.style.display = null;
				}
			}
		});
	}
}

function pipeline(id) {
	if(id == 'k-db'){
		var x = document.getElementById('k-insp');
		document.getElementById('inspector-module').style.display = 'none';
		x.firstElementChild.firstElementChild.className = x.firstElementChild.firstElementChild.className.substr(0,14);
		x.firstElementChild.nextElementSibling.nextElementSibling.className = x.firstElementChild.nextElementSibling.nextElementSibling.className.substr(0,13);

		return document.getElementById('database-module');

	} else if(id == 'k-insp') {
		if(!(document.getElementById('k-db').firstElementChild.firstElementChild.className.includes('db-active'))){
			return document.getElementById('inspector-module');
		}
	} else if(id == 'k-q') {
		return document.getElementById('query-module');
	}

	return null;
}

function init_query() {
	document.getElementById("query").firstElementChild.nextElementSibling.nextElementSibling.addEventListener("click", function() {
		var q = this.previousElementSibling.value;
		if(q != null) {
			app_refresh('q', 'q-results', 'q', encodeURI(q));
		}
	});
}

function app_refresh(t, e, v, s, r, z) {
	var xmlhttp = new XMLHttpRequest();
	var url = '../rf_admin.php';
	url += ('?m='+t+'&'+v+'='+s);
	if(r != null) {
		url += ('&'+r+'='+z);
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(e).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", url, false);
	xmlhttp.send();	
}
