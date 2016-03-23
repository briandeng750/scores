<?php
require_once 'vendor/autoload.php';
require "checkAuth.php";
$version="2";
?>

<html>
<head>
<title>LCC Gymnastics Scoring Program</title>
<link rel="stylesheet" href="css/south-street/jquery-ui-1.10.4.custom.css" />
<link rel="stylesheet" href="css/multiselect.css"></link>
<link rel="stylesheet" href="css/ezscore.css?build=<?=$version?>"></link>
<script src="js/spin.min.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="js/jquery-multiselect.min.js"></script>
<script src="js/ezscore.js?build=<?=$version?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	new EZScoreApp();
});
	</script>
</head>
<body>
	<div id="debug">
		<input type="checkbox" id="debugDisableBlur" />
	</div>
	<div id="top"><a class="linkButtons" href="logout.php" id="logOut">Log Out</a></div>
	<div id="topNav"></div>
	<div id="addTeamDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="teamName">Team Name:</label>
		</div>
		<div class="dlgRow">
			<input type="text" class="stretch" id="teamName" maxlength="128" />
		</div>
	</div>
	<div id="teamMembersDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="teamMembers"></label>
		</div>
		<div class="dlgRow">
			<table class="stretch">
				<tr>
					<td width="80%"><select size="15" class="stretch" id="teamMembers"></select>
					</td>
					<td>
						<div class="dlgRow">
							<button type="button" class="configBtn" id="importTeamMembers">Import...</button>
							<button type="button" class="configBtn" id="addTeamMember">Add...</button>
							<button type="button" class="configBtn" id="editTeamMember">Edit...</button>
							<button type="button" class="configBtn" id="deleteTeamMember">Delete...</button>
						</div>
					</td>
			
			</table>
		</div>
	</div>
	<div id="teamMemberDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="memberNumber">Number:</label>
		</div>
		<div class="dlgRow">
			<input id="memberNumber" type="text" maxlength="6" />
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="memberName">Name:</label>
		</div>
		<div class="dlgRow">
			<input id="memberName" class="stretch" type="text" maxlength="256" />
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="memberCategory">Category:</label>
		</div>
		<div class="dlgRow">
			<select id="memberCategory">
				<option value="">- Select -</option>
				<option value="JV">Junior Varsity</option>
				<option value="VC">Varsity Compulsory</option>
				<option value="VO">Varsity Optional</option>
			</select>
		</div>
	</div>
	<div id="importMembersDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="importMembers">Copy/Paste Competitor
				Information Below:</label> <br /> <label class="dlgLabel">Format for
				each line: Number Name (JV|VC|VO)</label> <br /> <label
				class="dlgLabel">Example: 111 Jane Doe JV</label>
		</div>
		<div class="dlgRow">
			<textarea id="importMembers" rows="15" class="fillWidth"></textarea>
		</div>
	</div>
	<div id="configDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="teams">Teams:</label>
		</div>
		<div class="dlgRow">
			<table class="stretch">
				<tr>
					<td width="70%"><select id="teams" size="6"></select></td>
					<td>
						<div class="dlgRow">
							<button type="button" class="configBtn" id="addTeam">Add...</button>
							<button type="button" class="configBtn" id="deleteTeam">Delete...</button>
							<button type="button" class="configBtn" id="editTeamMembers">Edit
								Members...</button>
						</div>
						<div class="dlgRow"></div>
					</td>
			
			</table>
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="homeTeams">Home Team:</label>
		</div>
		<div class="dlgRow">
			<select id="homeTeams"></select>
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="minOptionalScores">Minimum Optional
				Scores:</label>
		</div>
		<div class="dlgRow">
			<select id="minOptionalScores">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</div>
	</div>
	<div id="newMeetDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="meetDescription">Description:</label>
		</div>
		<div class="dlgRow">
			<input id="meetDescription" class="stretch" type="text"
				maxlength="256" />
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="meetDate">Date:</label>
		</div>
		<div class="dlgRow">
			<input id="meetDate" type="text" maxlength="256" />
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="meetTeams">Teams:</label>
		</div>
		<div class="dlgRow">
			<select id="meetTeams" multiple="multiple"></select>
		</div>
	</div>
	<div id="newCompetitorDlg" style="display: none;">
		<div class="dlgRow">
			<label class="dlgLabel" for="compNumber">Competitor Number:</label>
		</div>
		<div class="dlgRow">
			<input id="compNumber" type="text" maxlength="6" />
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="compName">Competitor Name:</label>
		</div>
		<div class="dlgRow">
			<input id="compName" class="stretch" type="text" maxlength="256" />
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="compTeam">Team:</label>
		</div>
		<div class="dlgRow">
			<select id="compTeam"></select>
		</div>
		<div class="dlgRow">
			<label class="dlgLabel" for="compCategory">Category:</label>
		</div>
		<div class="dlgRow">
			<select id="compCategory">
				<option value="">- Select -</option>
				<option value="JV">Junior Varsity</option>
				<option value="VC">Varsity Compulsory</option>
				<option value="VO">Varsity Optional</option>
			</select>
		</div>
	</div>
	<div id="indResultsTab" style="display: none;">
		<ul>
			<li><a href="#jvResults">Junior Varsity</a></li>
			<li><a href="#vcResults">Varsity Compulsory</a></li>
			<li><a href="#voResults">Varsity Optional</a></li>
		</ul>
		<div id="jvResults" class="nested-left">
			<ul>
				<li><a href="#jvVault">Vault</a></li>
				<li><a href="#jvBars">Bars</a></li>
				<li><a href="#jvBeam">Beam</a></li>
				<li><a href="#jvFloor">Floor</a></li>
				<li><a href="#jvAA">All Around</a></li>
			</ul>
			<div id="jvVault"></div>
			<div id="jvBars"></div>
			<div id="jvBeam"></div>
			<div id="jvFloor"></div>
			<div id="jvAA"></div>
		</div>
		<div id="vcResults" class="nested-left">
			<ul>
				<li><a href="#vcVault">Vault</a></li>
				<li><a href="#vcBars">Bars</a></li>
				<li><a href="#vcBeam">Beam</a></li>
				<li><a href="#vcFloor">Floor</a></li>
				<li><a href="#vcAA">All Around</a></li>
			</ul>
			<div id="vcVault"></div>
			<div id="vcBars"></div>
			<div id="vcBeam"></div>
			<div id="vcFloor"></div>
			<div id="vcAA"></div>
		</div>
		<div id="voResults" class="nested-left">
			<ul>
				<li><a href="#voVault">Vault</a></li>
				<li><a href="#voBars">Bars</a></li>
				<li><a href="#voBeam">Beam</a></li>
				<li><a href="#voFloor">Floor</a></li>
				<li><a href="#voAA">All Around</a></li>
			</ul>
			<div id="voVault"></div>
			<div id="voBars"></div>
			<div id="voBeam"></div>
			<div id="voFloor"></div>
			<div id="voAA"></div>
		</div>
	</div>
	<div id="teamResultsTab" style="display: none;">
		<ul>
			<li><a href="#jvTeamResults">Junior Varsity</a></li>
			<li><a href="#varsityTeamResults">Varsity</a></li>
		</ul>
		<div id="jvTeamResults"></div>
		<div id="varsityTeamResults"></div>
	</div>
	<div id="root"></div>
	<div id="loadingMessage"></div>
	<script type="text/javascript">
	var opts = {
		lines: 11, // The number of lines to draw
		length: 20, // The length of each line
		width: 10, // The line thickness
		radius: 30, // The radius of the inner circle
		corners: 1, // Corner roundness (0..1)
		rotate: 0, // The rotation offset
		direction: 1, // 1: clockwise, -1: counterclockwise
		color: '#000', // #rgb or #rrggbb or array of colors
		speed: 1, // Rounds per second
		trail: 60, // Afterglow percentage
		shadow: false, // Whether to render a shadow
		hwaccel: false, // Whether to use hardware acceleration
		className: 'spinner', // The CSS class to assign to the spinner
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		top: 'auto', // Top position relative to parent in px
		left: 'auto' // Left position relative to parent in px
	};
	var spinner = new Spinner(opts).spin(document.getElementById('loadingMessage'));
	</script>
</body>
</html>