/**
 * 
 *
 */

var CATEGORIES = ["JV", "VC", "VO"];
var EVENTS = ["VAULT", "BARS", "BEAM", "FLOOR", "ALLAROUND"];
var TABS = [
            ["jvVault", "jvBars", "jvBeam", "jvFloor", "jvAA"],
            ["vcVault", "vcBars", "vcBeam", "vcFloor", "vcAA"],
            ["voVault", "voBars", "voBeam", "voFloor", "voAA"]
            ];
var RESULT_HEADERS =[
                     ["JV Vault", "JV Bars", "JV Beam", "JV Floor", "JV All-Around"],
                     ["Varsity Compulsory Vault", "Varsity Compulsory Bars", "Varsity Compulsory Beam", "Varsity Compulsory Floor", "Varsity Compulsory All-Around"],
                     ["Varsity Optional Vault", "Varsity Optional Bars", "Varsity Optional Beam", "Varsity Optional Floor", "Varsity Optional All-Around"]
                     ];
var TEAM_EVENTS = ["ALLAROUND","VAULT", "BARS", "BEAM", "FLOOR"];
var TEAM_CATEGORIES = ["JV", "VARSITY"];
var TEAM_TABS = ["jvTeamResults", "varsityTeamResults" ];
var TEAM_HEADERS = {
		"VAULT" : "Vault",
		"BARS" : "Bars",
		"BEAM" : "Beam",
		"FLOOR" : "Floor",
		"ALLAROUND" : "Overall"
};

(function($) {
	$.extend({
		alert: function (message, title, callback) {
			$("<div></div>").dialog( {
				buttons: [{
					text: "OK",
					click: function () { $(this).dialog("close"); }
				}],
				close: function () { $(this).remove(); if (callback) callback();},
				resizable: false,
				title: title ? title : "Error",
				minWidth: 600,
				modal: true
			}).append($("<div/>", {'class': 'messageBox'}).append(message));
		},
		prompt: function(message, title, initialValue, validateCallback, okCallback) {
			var dlg = $('<div/>', {id: 'inputDialog'}).append($('<div/>', { 'class': 'messageBox' }).text(message));
			var initVal = initialValue || '';
			dlg.append($('<input/>', {id: 'dlg_text', style: 'width: 100%;', name: 'dlg_text', value: initVal}));
			var okHandler = function() {
				var slName = $("#inputDialog input").val();
				if (validateCallback(slName, $('#dlg_text'))) {
					dlg.dialog("close");
					dlg.remove();
					okCallback(slName);
				}
			};
			dlg.keypress(function(e) {
				if (e.keyCode == $.ui.keyCode.ENTER) {
					okHandler();
				}
			});
			dlg.dialog({
				modal: true,
				title: title,
				buttons: [
					{text: 'OK', click: okHandler },
					{text: 'Cancel', click:
						function() {
							dlg.dialog("close");
						}
					}],
				position: { my: "center", at: "center"},
				minWidth: 600,
				close: function(){ dlg.remove(); }
			});
		},
		confirm: function(message, title, callback) {
			$("<div></div>").dialog( {
				buttons: [{
					text: "Yes",
					click: function () {
						callback();
						$(this).dialog("close"); 
					}
				},
				{
					text: "No",
					click: function () {
						$(this).dialog("close"); 
					}
				}],
				close: function () { $(this).remove(); },
				resizable: false,
				title: title ? title : "Confirm?",
				minWidth: 600,
				modal: true
			}).append($("<div/>", {'class': 'messageBox'}).append(message));
		},
		format3: function(val) {
			return (val) ? val.toFixed(3) : '&nbsp;';
		},
		format4: function(val) {
			return (val) ? val.toFixed(4) : '&nbsp;';
		}
	});
})(jQuery);

function EZScorePrint(meetID, page) {
	$('#loadingMessage').show();
	spinner.spin($('#loadingMessage')[0]);
	
}

var windowResized = function () {
	var height = $(window).height() - $('#top').height() - $('#topNav').height() - 20;
	var root = $('#root');
	root.height(height);
};
$(window).resize(windowResized);

function EZScoreApp(meetID, page) {
	this.teamList = [];
	this.homeTeam = localStorage.getItem('homeTeam');
	this.teamMembers = [];
	this.minOptionalScores=localStorage.getItem('minOptionalScores');
	if (this.minOptionalScores == null) this.minOptionalScores = 2;
	if (meetID) {
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				action: "printResults", 
				meetID: meetID,
				minOptionalScores: this.minOptionalScores,
				page: page
				},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			var root = $('#printRoot');
			var results = $.parseJSON(msg);
			var table;
			var evtTable = null;
			var evtRow;
			if (results['scores']) {
				table = this.writeResultsTable(results['scores'], results['header']);
				root.append(table);
			} else if (results['teamResults']) {
				root.append($('<h1>').append(results['header']));
				root.append($('<p>').append('* indicates Varsity Optional score'));
				for (var j=0; j<TEAM_EVENTS.length; j++) {
					var evt = TEAM_EVENTS[j];
					if (results['teamResults'] && results['teamResults'][evt]) {
						table = this.writeTeamResultsTable(results['teamResults'][evt], TEAM_HEADERS[evt], evt);
					} else {
						table = $('<p>No results available</p>');
					}
					if (j==0) root.append(table);
					else {
						if (evtTable==null) {
							evtTable = $('<table/>',{class: 'meetEventResults'});
							root.append(evtTable);
						}
						if (j%2==1) {
							evtRow = $('<tr/>', {'class': 'breakAfter'});
							evtTable.append(evtRow);
						}
						var evtCell = $('<td/>');
						evtCell.append(table);
						evtRow.append(evtCell);
					}
				}
			} else {
				table = $('<p>No results available</p>');
				root.append(table);
			}
			this.hideSpinner();
			window.print();
		}.bind(this));
	} else {
		this.getMeets();
		this.allAroundCells = {};
		$('#meetDate').datepicker();
		$('#indResultsTab').tabs();
		$('#jvResults').tabs();
		$('#vcResults').tabs();
		$('#voResults').tabs();
		$('#teamResultsTab').tabs();
		$('#debug').hide();
		$('#addTeam').button().click(this.addTeamDlg.bind(this));
		$('#deleteTeam').button().click(this.deleteTeam.bind(this));
		$('#editTeamMembers').button().click(this.editTeamMembersDlg.bind(this));
		$('#addTeamMember').button().click(this.addTeamMemberDlg.bind(this));
		$('#importTeamMembers').button().click(this.importTeamMembersDlg.bind(this));
		$('#editTeamMember').button().click(this.editTeamMemberDlg.bind(this));
		$('#deleteTeamMember').button().click(this.deleteTeamMemberDlg.bind(this));		
		$('#meetTeams').multiselect({ selectedList: 6});
		$('#teamName').on('keypress', function(e) {
			if (e.keyCode == 13) {
				this.addTeam();
			}
		}.bind(this));
		$('#teams').change(function(e) {
			if ($('#teams').val()) {
				$('#deleteTeam').button('enable');
				$('#editTeamMembers').button('enable');
			}
		});
		$('#teamMembers').change(function(e) {
			if ($('#teamMembers').val()) {
				$('#editTeamMember').button('enable');
				$('#deleteTeamMember').button('enable');
			} else {
				$('#editTeamMember').button('disable');
				$('#deleteTeamMember').button('disable');
			}
		});
		windowResized();
	}
}
EZScoreApp.prototype = {
	constructor: EZScoreApp,
	showSpinner: function() {
		$('#loadingMessage').show();
		spinner.spin($('#loadingMessage')[0]);
	},
	hideSpinner: function() {
		spinner.stop();
		$('#loadingMessage').hide();
	},
	initParameters: function() {
		$.ajax({ type: 'POST', url: 'getData.php',
			data: {action: 'getInitParameters'},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		}).done(function(msg) {
			var parms = $.parseJSON(msg);
			if (parms.hasOwnProperty("HOMETEAM") && this.homeTeam == null) {
				this.homeTeam = parms["HOMETEAM"];
			}
			if (parms.hasOwnProperty("TEAMS")) {
				$('#meetTeams').empty();
				var teams = parms["TEAMS"].split(',');
				this.teamList = [];
				for (var i=0; i<teams.length; i++) {
					var team = teams[i];
					var opt = $('<option></option>', {value: team});
					opt.text(team);
					this.teamList.push(team);
					opt.prop('selected', team === this.homeTeam);
					$('#meetTeams').append(opt);
				}
			}
		}.bind(this));
	},
	getMeets: function() {
		this.showSpinner();
		this.currentMeet = null;
		$('#indResultsTab').hide();
		$('#teamResultsTab').hide();
		this.homeMenu();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: {action: 'list'},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		}).done(function(msg) {
			this.loadMeets($.parseJSON(msg)['Meets']);
			this.initParameters();
			this.hideSpinner();
		}.bind(this));
	},
	homeMenu: function() {
		$('#topNav').empty();
		var outerDiv = $('<div/>', {class: 'dlgRow'});
		var btnDiv = $('<div/>', {class: 'dlgRowLeft'});
		var addMeet = $('<button>', {'type': 'button'}).button({label: 'Add Meet...'});
		addMeet.click(this.addMeetDlg.bind(this));
		btnDiv.append(addMeet);
		outerDiv.append(btnDiv);
		btnDiv = $('<div/>', {class: 'dlgRowRight'});
		var config = $('<button>', {'type': 'button'}).button({label: 'Settings...'});
		config.click(this.configDlg.bind(this));
		btnDiv.append(config);
		outerDiv.append(btnDiv);
		$('#topNav').append(outerDiv);
	},
	loadMeets: function(meets) {
		$('#root').empty();
		var table = $('<table></table>', {class: 'meetResults'});
		var tbody = $('<tbody></tbody>');
		table.append(tbody);
		var tr = $('<tr>');
		tr.append($('<th>', {class: 'col18px'}).append('&nbsp;'));
		tr.append($('<th>', {class: 'col70pc'}).text('Meet'));
		tr.append($('<th>', {class: 'col30pc'}).text('Date'));
		tbody.append(tr);
		for (var i=0; i<meets.length; i++) {
			tr = $('<tr>');
			var delBtn = $('<img/>', {src: 'css/images/trashcan.png', class: 'clickable'});
			delBtn.click({
				meetID: meets[i].Id,
				meetDesc: meets[i].Description
				}, this.deleteMeet.bind(this));
			tr.append($('<td>', {class: 'col18px'}).append(delBtn));
			var link = $('<a>', {class: 'clickable'});
			link.text(meets[i].Description);
			link.click({id: meets[i].Id}, function(e) {
				this.showMeet(e.data.id);
			}.bind(this));
			tr.append($('<td>', {class: 'col70pc'}).append(link));
			tr.append($('<td>', {class: 'col30pc'}).text(meets[i].DateString));
			tbody.append(tr);
		}
		$('#root').append(table);
	},
	deleteMeet: function(e) {
		$.confirm('Delete is permanent! Are you sure you want to delete the meet ['+e.data.meetDesc+'] and all of the data?', null, function() {
			this.showSpinner();
			$.ajax({ type: 'POST', url: 'getData.php',
				data: {
					action: 'deleteMeet',
					meetID: e.data.meetID
				},
				error: function(jqXHR, textStatus, errorThrown) {
					this.hideSpinner();
					$.alert('An unexpected error occurred: ' + jqXHR.responseText);
				}.bind(this)
			}).done(function(msg) {
				this.loadMeets($.parseJSON(msg)['Meets']);
				this.hideSpinner();
			}.bind(this));
		}.bind(this));
	},
	meetMenu: function() {
		var outerDiv = $('<div/>', {class: 'dlgRow'});
		var btnDiv = $('<div/>', {class: 'dlgRowLeft'});
		var home=$('<button>', {type: 'button'}).button({label: 'Home'});
		home.click(this.getMeets.bind(this));
		btnDiv.append(home);
		var addComp=$('<button>', {type: 'button'}).button({label: 'Add Competitor...'});
		addComp.click(this.addCompetitorDlg.bind(this));
		btnDiv.append(addComp);
		outerDiv.append(btnDiv);
		var btnDiv = $('<div/>', {class: 'dlgRowRight'});
		var indResults=$('<button>', {type: 'button'}).button({label: 'Individual Results'});
		indResults.click(this.showIndResults.bind(this));
		btnDiv.append(indResults);
		var teamResults=$('<button>', {type: 'button'}).button({label: 'Team Results'});
		teamResults.click(this.showTeamResults.bind(this));
		btnDiv.append(teamResults);
		outerDiv.append(btnDiv);
		outerDiv.append('<br style="clear: left;" />');
		$('#topNav').append(outerDiv);
	},
	addMeetDlg: function() {
		$('#meetTeams').multiselect("refresh");
		$('#newMeetDlg').dialog({
			autoOpen: true,
			modal: true,
			title: 'Create Meet',
			buttons: [
					{text: "OK", click: this.createMeet.bind(this)},
					{text: "Cancel", click: function() {$('#newMeetDlg').dialog('close');}}
					],
				position: ['center', 'center'],
				minWidth: 600
		});
	},
	configDlg: function() {
		$('#minOptionalScores').val(this.minOptionalScores);
		this.loadTeams();
		$('#deleteTeam').button('disable');
		$('#editTeamMembers').button('disable');
		$('#configDlg').dialog({
			autoOpen: true,
			modal: true,
			title: 'Settings',
			buttons: [
					{text: "OK", click: this.saveConfig.bind(this)},
					{text: "Cancel", click: function() {$('#configDlg').dialog('close');}}
					],
			position: ['center', 'center'],
			minWidth: 600,
		});
	},
	loadTeams: function() {
		$('#teams').empty();
		$('#homeTeams').empty();
		for (var i=0; i<this.teamList.length; i++) {
			var team = this.teamList[i];
			$('#teams').append($('<option></option>', {value: team}).text(team));
			$('#homeTeams').append($('<option></option>', {value: team}).text(team));
		}
		$('#homeTeams').val(this.homeTeam);
	},
	saveConfig: function() {
		this.homeTeam = $('#homeTeams').val();
		this.minOptionalScores = $('#minOptionalScores').val();
		localStorage.setItem('homeTeam',this.homeTeam);
		localStorage.setItem('minOptionalScores',this.minOptionalScores);
		$("#meetTeams > option:selected").removeAttr("selected");
		$('#meetTeams option[value="'+this.homeTeam+'"]').prop('selected',true);
		$('#configDlg').dialog('close');
	},
	addTeamDlg: function() {
		$('#teamName').val('');
		$('#addTeamDlg').dialog({
			autoOpen: true,
			modal: true,
			title: 'Add Team',
			buttons: [
					{text: "OK", click: this.addTeam.bind(this)},
					{text: "Cancel", click: function() {$('#addTeamDlg').dialog('close');}}
					],
			position: ['center', 'center'],
			minWidth: 600,
		});
	},
	addTeam: function() {
		var teamName = $('#teamName').val().trim();
		if (!teamName) {
			$.alert('Please enter a team name', 'Error', function() {
				$('#teamName').focus();
			});
			return;
		}
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: {
				action: 'addTeam',
				teamName: teamName
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('Error occurred adding team: ' + jqXHR.responseText);
			}.bind(this)
		}).done(function(msg) {
			this.hideSpinner();
			$('#addTeamDlg').dialog('close');
			var teams = $.parseJSON(msg);
			this.teamList = [];
			for (var i=0; i<teams.length; i++) {
				this.teamList.push(teams[i]);
			}
			this.loadTeams();
		}.bind(this));
	},
	deleteTeam: function() {
		var teamName = $('#teams').val();
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: {
				action: 'deleteTeam',
				teamName: teamName
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		}).done(function(msg) {
			this.hideSpinner();
			//$('#addTeamDlg').dialog('close');
			var teams = $.parseJSON(msg);
			this.teamList = [];
			for (var i=0; i<teams.length; i++) {
				this.teamList.push(teams[i]);
			}
			this.loadTeams();
		}.bind(this));
	},
	createMeet: function() {
		var desc = $('#meetDescription').val().trim();
		var date = $('#meetDate').val();
		var teams = $('#meetTeams').val();
		if (desc.trim().length===0) {
			$.alert("Please enter a Meet description");
			$('#meetDescription').focus();
			return;
		}
		if (date.trim().length===0) {
			$.alert("Please enter the date of the Meet");
			$('#meetDate').focus();
			return;
		}
		if (!teams || teams.length<2) {
			$.alert("Please select at least 2 teams for the Meet");
			$('#meetTeams').focus();
			return;
		}
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				'action': "newMeet", 
				'description': desc,
				'date': date,
				'teams' : teams.join(),
				'homeTeam' : this.homeTeam
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			this.getMeets();
			$('#newMeetDlg').dialog('close');
			this.hideSpinner();
		}.bind(this));
	},
	showMeet: function(meetId) {
		$('#root').empty();
		$('#topNav').empty();
		$('#indResultsTab').hide();
		$('#teamResultsTab').hide();
		this.meetMenu();
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				action: "getMeet", 
				order: 'team',
				meetID: meetId 
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			var meet = $.parseJSON(msg);
			this.currentMeet = meet;
			var table = $('<table></table>', {class: 'meetResults'});
			var tbody = $('<tbody></tbody>');
			var tr;
			var headrow = $('<tr>');
			headrow.append($('<th/>', {class: 'col18px'}).append('&nbsp;'));
			headrow.append($('<th/>', {class: 'col10pc'}).append('#'));
			headrow.append($('<th/>', {class: 'col20pc'}).append('Name'));
			headrow.append($('<th/>', {class: 'col15pc'}).append('Team'));
			headrow.append($('<th/>', {class: 'col5pc'}).append('Category'));
			headrow.append($('<th/>', {class: 'col10pc'}).append('Vault'));
			headrow.append($('<th/>', {class: 'col10pc'}).append('Bars'));
			headrow.append($('<th/>', {class: 'col10pc'}).append('Beam'));
			headrow.append($('<th/>', {class: 'col10pc'}).append('Floor'));
			headrow.append($('<th/>', {class: 'col10pc'}).append('All-Around'));
			tbody.append(headrow);
			table.append(tbody);			
			$('#root').append(table);
			var competitors = [];
			if (meet.hasOwnProperty('MeetCompetitors')) {
				for (var j=0; j<meet['MeetCompetitors'].length; j++) {
					competitors.push(meet['MeetCompetitors'][j]['Competitor'])
				}
			}
			competitors.sort(function(a,b) {
				if (parseInt(a.Number)<parseInt(b.Number)) return -1;
				else if (parseInt(a.Number) === parseInt(b.Number)) return 0;
				else return 1;
			});
			for (var i=0; i<competitors.length; i++) {
				var competitor = competitors[i];
				tr = $('<tr/>', {class: 'competitorRow'});
				if (i%2) {
					tr.addClass('altRow');
				}
				var delBtn = $('<img/>', {src: 'css/images/trashcan.png', class: 'clickable'});
				delBtn.click(
						{
							number: competitor.Number,
							name: competitor.Name
						}, 
						this.deleteCompetitor.bind(this));
				tr.append($('<td>', {class: 'col18px'}).append(delBtn));
				tr.append(this.createCompCell(competitor, 'clickable col10pc', competitor.Number));
				tr.append(this.createCompCell(competitor, 'clickable col20pc', competitor.Name));
				tr.append(this.createCompCell(competitor, 'clickable col15pc', competitor.Team));
				tr.append(this.createCompCell(competitor, 'clickable col5pc', competitor.Category));
				
				tr.append(this.createScoreCell(meet.Id, competitor,'VAULT'));
				tr.append(this.createScoreCell(meet.Id, competitor,'BARS'));
				tr.append(this.createScoreCell(meet.Id, competitor,'BEAM'));
				tr.append(this.createScoreCell(meet.Id, competitor,'FLOOR'));
				tr.append(this.createAllAroundCell(competitor));
				tbody.append(tr);
			}
			this.hideSpinner();
		}.bind(this));
	},
	deleteCompetitor: function(e) {
		$.confirm('Delete is permanent! Are you sure you want to delete the competitor ['+e.data.name+'] and all scores?', null, function() {
			this.showSpinner();
			$.ajax({ type: 'POST', url: 'getData.php',
				data: { 
					action: "deleteCompetitor", 
					meetID: this.currentMeet.Id,
					number: e.data.number
				},
				error: function(jqXHR, textStatus, errorThrown) {
					this.hideSpinner();
					$.alert('An unexpected error occurred: ' + jqXHR.responseText);
				}.bind(this)
			})
			.done(function(msg) {
				var meet = $.parseJSON(msg);
				this.currentMeet = meet;
				this.showMeet(this.currentMeet.Id);
				this.hideSpinner();
			}.bind(this));
		}.bind(this));
	},
	createCompCell: function(competitor, className, text) {
		var cell = $('<td/>', {'class': className}).append(text);
		cell.click({competitor: competitor}, this.editCompetitor.bind(this));
		return cell;
	},
	editCompetitor: function(e) {
		this.showCompetitorDlg(e.data.competitor);
	},
	showCompetitorDlg: function(competitor) {
		var isAdd = competitor === undefined;
		var title;
		var btnText;
		var teamSel = $('#compTeam');
		teamSel.empty();
		teamSel.append(new Option('- Select -', ''));
		for (var i=0; i<this.currentMeet.teams.length; i++) {
			teamSel.append(new Option(this.currentMeet.teams[i]));
		}
		if (isAdd) {
			title = 'Add Competitor';
			btnText = 'Add and Close';
			$('#compNumber').prop('disabled', false);
			$('#compNumber').val('');
			$('#compName').val('');
			$('#compTeam').val('');
			$('#compCategory').val('');
		} else {
			title = 'Edit Competitor';
			btnText = 'OK';
			$('#compNumber').val(competitor.Number);
			$('#compNumber').prop('disabled', true);
			$('#compName').val(competitor.Name);
			$('#compTeam').val(competitor.Team);
			$('#compCategory').val(competitor.Category);
		}
		var buttons = [];
		if (isAdd) {
			buttons.push({
				text: "Add and Continue", click: function(e) { this.createCompetitor(true);}.bind(this)
			});
		}
		buttons.push({
			text: btnText, click: function(e) {
				if (isAdd) this.createCompetitor();
				else this.updateCompetitor(competitor);
			}.bind(this)
		});
		buttons.push({text: "Cancel", click: function() {$('#newCompetitorDlg').dialog('close');}});
		$('#newCompetitorDlg').dialog({
			autoOpen: true,
			modal: true,
			title: title,
			position: {my: "center", at: "center", of: 'body'},
			buttons: buttons,
			minWidth: 600
		});
	},
	addCompetitorDlg: function(e) {
		this.showCompetitorDlg();
	},
	updateCompetitor: function(competitor) {
		var name = $('#compName').val().trim();
		var team = $('#compTeam').val();
		var category = $('#compCategory').val();
		if (!this.validateCompetitor(competitor)) {
			return;
		}
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				'action': "updateCompetitor", 
				'meetID': this.currentMeet.Id,
				'name': name ,
				'number': competitor.Number,
				'team' : team,
				'category' : category
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			this.showMeet(this.currentMeet.Id);
			$('#newCompetitorDlg').dialog('close');
			this.hideSpinner();
		}.bind(this));
		
	},
	validateCompetitor: function(competitor) {
		var num = $('#compNumber').val().trim();
		var name = $('#compName').val().trim();
		var team = $('#compTeam').val();
		var category = $('#compCategory').val();
		if (!num || !$.isNumeric(num)) {
			$.alert('Please enter a number for Competitor Number', 'Error', function() {$('#compNumber').select().focus();});
			return false;
		}
		if (!competitor && this.meetHasCompetitor(num)) {
			$.alert('The Competitor Number you entered is already in use.<br/>Please enter a unique Competitor Number', 'Error', 
					function() {$('#compNumber').select().focus();});
			return false;
		}
		if (!name) {
			$.alert('Please enter a value for Competitor Name', 'Error', function() {$('#compName').select().focus();});
			return false;
		}
		if (!team) {
			$.alert('Please select a Team', 'Error', function() {$('#compTeam').select().focus();});
			return false;
		}
		if (!category) {
			$.alert('Please select the competitor\'s Category', 'Error', function() {$('#compCategory').focus();});
			return false;
		}
		return true;
	},
	createCompetitor: function(cont) {
		var num = $('#compNumber').val().trim();
		var name = $('#compName').val().trim();
		var team = $('#compTeam').val();
		var category = $('#compCategory').val();
		if (!this.validateCompetitor()) {
			return;
		}
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				'action': "addCompetitor", 
				'meetID': this.currentMeet.Id,
				'name': name ,
				'number': num,
				'team' : team,
				'category' : category
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			this.hideSpinner();
			this.showMeet(this.currentMeet.Id);
			if (cont) {
				$('#compName').val('');
				$('#compNumber').val(parseInt(num)+1);
			} else {
				$('#newCompetitorDlg').dialog('close');
			}
		}.bind(this));
	},
	meetHasCompetitor: function(num) {
		for (var compNum in this.currentMeet.competitors) {			
			if (!this.currentMeet.competitors.hasOwnProperty(compNum)) continue;
			if (compNum === num) return true;
		}
		return false;
	},
	createScoreCell: function(meetID, competitor, event) {
		var cell = $('<td/>', {class: 'clickable col10pc'});
		cell.append($('<div/>', {class: 'scoreCell'}).append($.format3(competitor.competitorResults[event])));
		cell.click({meetID: meetID, event: event, competitor: competitor}, this.editScore.bind(this));
		return cell;
	},
	createAllAroundCell: function(competitor) {
		this.allAroundCells[competitor.Number] = $('<div/>', {class: 'scoreCell'}).append($.format4(competitor.competitorResults['ALLAROUND']));
		var cell = $('<td/>').append(this.allAroundCells[competitor.Number]);
		return cell;
	},
	editScore: function(e) {
		cell = $(e.target).parents('td');
		cell.empty();
		cell.css('padding', '0');
		var score = e.data.competitor.competitorResults[e.data.event];
		var input = $('<input/>', {type: 'text', value: score, class: 'scoreInput'});
		input.change({
			meetID: e.data.meetID, 
			event: e.data.event, 
			competitor: e.data.competitor
			}, this.updateScore.bind(this));
		cell.append(input);
		input.keyup({score: score}, function(e) {
			if (e.keyCode == 27) {
				this.hideInput($(e.target), e.data.score);
			}
		}.bind(this));
		input.blur({score: score}, this.cancelUpdate.bind(this));
		input.focus().select();
	},
	cancelUpdate: function(e) {
		if ($('#debugDisableBlur').is(':checked')) return;
		var input = $(e.target);
		var newValue = input.val().trim();
		if ((!e.data.score && !newValue) || (newValue==e.data.score)) {
			this.hideInput(input, e.data.score);
		}
	},
	hideInput: function(input, score) {
		var cell = input.parents('td');
		cell.empty();
		cell.removeAttr('style');
		cell.append($('<div/>', {class: 'scoreCell'}).append($.format3(score)));
	},
	isValidScore: function(score) {
		if (score==='') return true;
		var valid = (score.match(/^\d*(\.\d+)?$/));
		if (!valid) return false;
		var ns = parseFloat(score);
		return (ns>0 && ns<=10);
	},
	updateScore: function(e) {
		var input = $(e.target);
		var newScore = input.val().trim();
		console.log("updateScore called");
		if (!this.isValidScore(newScore)) {
			$.alert('Please enter a valid score between 0 and 10', 'Error', function() {
				input.select().focus();
			});
			return;
		}
		var cell = input.parents('td');
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				action: "updateScore", 
				meetID: e.data.meetID,
				competitorNumber: e.data.competitor.Number,
				event: e.data.event,
				score: input.val().trim()
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			var newComp = $.parseJSON(msg);
			cell.empty();
			cell.append($('<div/>', {class: 'scoreCell'}).append($.format3(newComp.competitorResults[e.data.event])));
			this.allAroundCells[newComp.Number].empty().append($.format4(newComp.competitorResults['ALLAROUND']));
			e.data.competitor.competitorResults[e.data.event] = newComp.competitorResults[e.data.event];
			e.data.competitor.competitorResults['ALLAROUND'] = newComp.competitorResults['ALLAROUND'];
			this.hideSpinner();
		}.bind(this));
	},
	showIndResults: function() {
		this.showSpinner();
		$('#topNav').empty();
		this.resultsMenu();
		$('#root').empty();
		$('#teamResultsTab').hide();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				action: "individualResults", 
				meetID: this.currentMeet.Id
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			var tabs = $('#indResultsTab');
			var results = $.parseJSON(msg);
			for (var i=0; i<CATEGORIES.length; i++) {
				var cat = CATEGORIES[i];
				for (var j=0; j<EVENTS.length; j++) {
					var evt = EVENTS[j];
					var table;
					if (results['results'][cat] && results['results'][cat]['results'][evt]) {
						table = this.writeResultsTable(results['results'][cat]['results'][evt], RESULT_HEADERS[i][j]);
					} else {
						table = $('<p>No results available</p>');
					}
					$('#'+TABS[i][j]).empty().append(table);
				}
			}
			tabs.show();
			this.hideSpinner();
		}.bind(this));
	},
	writeResultsTable: function(scores, header) {
		var table = $('<table></table>', {class: 'meetResults'});
		var tbody = $('<tbody></tbody>');
		var tr;
		tbody.append($('<tr>').append($('<td>', {colspan: 5, class: 'ui-widget-header ui-state-default'}).append(header)));
		var headrow = $('<tr>');
		headrow.append($('<th>', {class: 'col10pc'}).text('Place'));
		headrow.append($('<th>', {class: 'col10pc'}).text('#'));
		headrow.append($('<th>').text('Name'));
		headrow.append($('<th>', {class: 'col15pc'}).text('Team'));
		headrow.append($('<th>', {class: 'col10pc'}).text('Score'));
		tbody.append(headrow);
		var lastScore = null;
		var place = 1;
		for (var k=0; k<scores.length; k++) {
			if (lastScore!=null && lastScore !== scores[k].score) {
				place=(k+1);
			}
			tr = $('<tr>');
			if (k%2) {
				tr.addClass('altRow');
			}
			tr.append($('<td>', {class: 'col10pc'}).text(place));
			tr.append($('<td>', {class: 'col10pc'}).text(scores[k].number));
			tr.append($('<td>').text(scores[k].name));
			tr.append($('<td>', {class: 'col15pc'}).text(scores[k].team));
			tr.append($('<td>', {class: 'col10pc'}).text($.format4(scores[k].score)));
			lastScore = scores[k].score;
			tbody.append(tr);
		}
		table.append(tbody);
		return table;
	},
	showTeamResults: function() {
		this.showSpinner();
		$('#topNav').empty();
		this.resultsMenu(true);
		$('#root').empty();
		$('#indResultsTab').hide();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				action: "teamResults", 
				meetID: this.currentMeet.Id,
				minOptionalScores: this.minOptionalScores
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			var tabs = $('#teamResultsTab');
			var results = $.parseJSON(msg);
			for (var i=0; i<TEAM_CATEGORIES.length; i++) {
				$('#'+TEAM_TABS[i]).empty();
				var cat = TEAM_CATEGORIES[i];
				if (cat === "VARSITY") {
					$('#'+TEAM_TABS[i]).append($('<p>').append('* indicates Varsity Optional score'));
				}
				for (var j=0; j<TEAM_EVENTS.length; j++) {
					var evt = TEAM_EVENTS[j];
					var table;
					if (results['teamResults'][cat] && results['teamResults'][cat][evt]) {
						table = this.writeTeamResultsTable(results['teamResults'][cat][evt], TEAM_HEADERS[evt], evt);
					} else {
						table = $('<p>No results available</p>');
					}
					$('#'+TEAM_TABS[i]).append(table);
					$('#'+TEAM_TABS[i]).append('<hr/>');
				}
			}		
			tabs.show();
			this.hideSpinner();
		}.bind(this));
	},
	writeTeamResultsTable: function(scores, header, evt) {
		var table = $('<table></table>', {class: 'meetResults'});
		var tbody = $('<tbody></tbody>');
		var tr;
		tbody.append($('<tr>').append($('<td>', {colspan: 3, class: 'ui-widget-header ui-state-default'}).append(header)));
		var headrow = $('<tr>');
		headrow.append($('<th>', {class: 'col10pc'}).text('Place'));
		headrow.append($('<th>', {class: 'col15pc'}).text('Team'));
		headrow.append($('<th>', {class: 'col10pc'}).text('Score'));
		tbody.append(headrow);
		var lastScore = null;
		var place = 1;
		for (var k=0; k<scores.length; k++) {
			if (lastScore!=null && lastScore !== scores[k].score) {
				++place;
			}
			tr = $('<tr>');
			tr.append($('<td>', {class: 'col10pc'}).text(place));
			tr.append($('<td>').text(scores[k].team));
			tr.append($('<td>', {class: 'col10pc'}).append($.format4(scores[k].score)));
			lastScore = scores[k].score;
			tbody.append(tr);
			if (scores[k].includedScores && evt !== "ALLAROUND") {
				this.writeTeamIndividualScores(tbody, scores[k].includedScores);
			}
		}
		table.append(tbody);
		return table;
	},
	writeTeamIndividualScores: function(tbody, indScores) {
		var tr,cellClass;
		for (var i=0; i<indScores.length; i++) {
			cellClass = indScores[i].isOptional ? "optScore" : "compScore"; 
			tr = $('<tr>');
			tr.append($('<td>').append('&nbsp;'));
			tr.append($('<td>', {'class': cellClass}).append(indScores[i].name));
			tr.append($('<td>').append($.format3(indScores[i].score)));
			tbody.append(tr);
		}
		
	},
	resultsMenu: function(isTeam) {
		var outerDiv = $('<div/>', {class: 'dlgRow'});
		var btnDiv = $('<div/>', {class: 'dlgRowLeft'});
		var home=$('<button>', {type: 'button'}).button({label: 'Home'});
		home.click(this.getMeets.bind(this));
		btnDiv.append(home);
		var back=$('<button>', {type: 'button'}).button({label: '< Back to Scoresheet'});
		back.click(this.backToMeet.bind(this));
		btnDiv.append(back);
		outerDiv.append(btnDiv);
		btnDiv = $('<div/>', {class: 'dlgRowRight'});
		if (isTeam) {
			var indResults=$('<button>', {type: 'button'}).button({label: 'Show Individual Results'});
			indResults.click(this.showIndResults.bind(this));
			btnDiv.append(indResults);
		} else {
			var teamResults=$('<button>', {type: 'button'}).button({label: 'Show Team Results'});
			teamResults.click(this.showTeamResults.bind(this));
			btnDiv.append(teamResults);
		}
		var print=$('<button>', {type: 'button'}).button({label: 'Print...'});
		print.click({isTeam: isTeam}, this.printView.bind(this));
		btnDiv.append(print);
		var exportBtn=$('<button>', {type: 'button'}).button({label: 'Export...'});
		exportBtn.click(this.exportResults.bind(this));
		btnDiv.append(exportBtn);
		outerDiv.append(btnDiv);
		$('#topNav').append(outerDiv);
	},
	exportResults: function(e) {
		$.prompt('How many places?', 'Export Results', '6', function(val, ele) {
			if (!$.isNumeric(val)) {
				$.alert("Please enter a valid number!");
				ele.focus();
				return false;
			}
			return true;
		},
		function(val) {
			window.location = 'export.php?meetId='+this.currentMeet.Id+'&toPlace='+val;
		}.bind(this));
	},
	printView: function(e) {
		var resultsPage = undefined;
		var active = undefined;
		if (e.data.isTeam) {
			active = $('#teamResultsTab').tabs('option', 'active');
			if (active == 0) {
				resultsPage = 'jvteam';
			} else {
				resultsPage = 'varsityteam';
			}
		} else {
			var cat = $('#indResultsTab').tabs('option', 'active');
			if (cat == 0) {
				active = $('#jvResults').tabs('option', 'active');
			} else if (cat == 1) {
				active = $('#vcResults').tabs('option', 'active');
			} else if (cat == 2) {
				active = $('#voResults').tabs('option', 'active');
			} else {
				$.alert("Unknown results page!");
				return;
			}
			resultsPage = TABS[cat][active];
		}
		var url = 'print.php?meetID='+this.currentMeet.Id + '&page='+resultsPage;
		window.open(url, 'EZ_printView');
	},
	backToMeet: function(e) {
		this.showMeet(this.currentMeet.Id);
	},
	loadTeamMembers: function() {
		var compSel = $('#teamMembers');
		compSel.empty();
		var text;
		for (var i=0; i<this.teamMembers.length; i++) {
			text = this.teamMembers[i].Number+' - '+ this.teamMembers[i].Name +
				'  ('+this.teamMembers[i].Category+')';
			compSel.append($('<option/>', {value: i}).text(text));
		}
		$('#editTeamMember').button('disable');
		$('#deleteTeamMember').button('disable');
	},
	editTeamMembersDlg: function() {
		var team = $('#teams').val();
		if (!team) return;
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { action: "getTeamMembers", teamName: team },
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			this.teamMembers = $.parseJSON(msg)['TeamMembers'];
			this.loadTeamMembers();
			this.hideSpinner();
			$('#teamMembersDlg').dialog({
				autoOpen: true,
				modal: true,
				title: 'Edit Team Members',
				buttons: [
						{text: "Done", click: function() {$('#teamMembersDlg').dialog('close');}}
						],
					position: ['center', 'center'],
					minWidth: 600
			});
		}.bind(this));
	},
	addTeamMemberDlg: function() {
		this.showTeamMemberDlg();
	},
	importTeamMembersDlg: function() {
		$('#importMembers').val('');
		$('#importMembersDlg').dialog({
			autoOpen: true,
			modal: true,
			title: 'Import Team Members',
			buttons: [
			          {text: "Import", click: this.doImport.bind(this)},
			          {text: "Cancel", click: function() {$('#importMembersDlg').dialog('close');}}
			          ],
			minWidth: 600
		});
	},
	doImport: function() {
		var team = $('#teams').val();
		if (!team) return;
		var text = $('#importMembers').val();
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				'action': "importTeamMembers",
				'teamName' : team,
				'text': text
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('Error occurred importing team members: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			this.hideSpinner();
			this.teamMembers = $.parseJSON(msg)['TeamMembers'];
			this.loadTeamMembers();
			$('#importMembersDlg').dialog('close');
		}.bind(this));
	},
	showTeamMemberDlg: function(competitor) {
		var isAdd = competitor === undefined;
		var title;
		var btnText;
		if (isAdd) {
			title = 'Add Member';
			btnText = 'Add and Close';
			$('#memberNumber').prop('disabled', false);
			$('#memberNumber').val('');
			$('#memberName').val('');
			$('#memberCategory').val('');
		} else {
			title = 'Edit Member';
			btnText = 'OK';
			$('#memberNumber').val(competitor.Number);
			$('#memberNumber').prop('disabled', true);
			$('#memberName').val(competitor.Name);
			$('#memberCategory').val(competitor.Category);
		}
		var buttons = [];
		if (isAdd) {
			buttons.push({
				text: "Add and Continue", click: function(e) { this.createTeamMember(true);}.bind(this)
			});
		}
		buttons.push({
			text: btnText, click: function(e) {
				if (isAdd) this.createTeamMember();
				else this.updateTeamMember(competitor);
			}.bind(this)
		});
		buttons.push({text: "Cancel", click: function() {$('#teamMemberDlg').dialog('close');}});
		$('#teamMemberDlg').dialog({
			autoOpen: true,
			modal: true,
			title: title,
			buttons: buttons,
			minWidth: 600
		});
	},
	createTeamMember: function(cont) {
		var team = $('#teams').val();
		if (!team) return;
		var num = $('#memberNumber').val().trim();
		var name = $('#memberName').val().trim();
		var category = $('#memberCategory').val();
		if (!this.validateTeamMember()) {
			return;
		}
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				'action': "addTeamMember",
				'teamName' : team,
				'name': name ,
				'number': num,
				'category' : category
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			this.hideSpinner();
			this.teamMembers = $.parseJSON(msg)['TeamMembers'];
			this.loadTeamMembers();
			if (cont) {
				$('#memberName').val('');
				$('#memberNumber').val(parseInt(num)+1);
			} else {
				$('#teamMemberDlg').dialog('close');
			}
		}.bind(this));
	},
	updateTeamMember: function(competitor) {
		var team = $('#teams').val();
		if (!team) return;
		var name = $('#memberName').val().trim();
		var category = $('#memberCategory').val();
		if (!this.validateTeamMember(competitor)) {
			return;
		}
		this.showSpinner();
		$.ajax({ type: 'POST', url: 'getData.php',
			data: { 
				'action': "updateTeamMember", 
				'teamName' : team,
				'name': name ,
				'number': competitor.Number,
				'category' : category
			},
			error: function(jqXHR, textStatus, errorThrown) {
				this.hideSpinner();
				$.alert('An unexpected error occurred: ' + jqXHR.responseText);
			}.bind(this)
		})
		.done(function(msg) {
			$('#teamMemberDlg').dialog('close');
			this.teamMembers = $.parseJSON(msg)['TeamMembers'];
			this.loadTeamMembers();
			this.hideSpinner();
		}.bind(this));
	},
	validateTeamMember: function(competitor) {
		var num = $('#memberNumber').val().trim();
		var name = $('#memberName').val().trim();
		var category = $('#memberCategory').val();
		if (!num || !$.isNumeric(num)) {
			$.alert('Please enter a number for Number', 'Error', function() {$('#memberNumber').select().focus();});
			return false;
		}
		if (!competitor && this.teamHasMember(num)) {
			$.alert('The Number you entered is already in use.<br/>Please enter a unique Number', 'Error', 
					function() {$('#compNumber').select().focus();});
			return false;
		}
		if (!name) {
			$.alert('Please enter a value for Name', 'Error', function() {$('#memberName').select().focus();});
			return false;
		}
		if (!category) {
			$.alert('Please select the Category', 'Error', function() {$('#memberCategory').focus();});
			return false;
		}
		return true;
	},
	teamHasMember: function(number) {
		for (var i=0; i<this.teamMembers.length; i++) {
			if (this.teamMembers[i].Number === number) return true;
		}
		return false;
	},
	editTeamMemberDlg: function() {
		var selCompVal = $('#teamMembers').val();
		var selCompetitor = this.teamMembers[selCompVal];
		this.showTeamMemberDlg(selCompetitor);
	},
	deleteTeamMemberDlg: function() {
		var selCompVal = $('#teamMembers').val();
		var selCompetitor = this.teamMembers[selCompVal];
		var team = $('#teams').val();
		if (!team) return;
		$.confirm('Are you sure you want to delete the member ['+selCompetitor.Name+']?', null, function() {
			this.showSpinner();
			$.ajax({ type: 'POST', url: 'getData.php',
				data: {
					action: 'deleteTeamMember',
					teamName: team,
					number: selCompetitor.Number
				},
				error: function(jqXHR, textStatus, errorThrown) {
					this.hideSpinner();
					$.alert('An unexpected error occurred: ' + jqXHR.responseText);
				}.bind(this)
			}).done(function(msg) {
				this.teamMembers = $.parseJSON(msg)['TeamMembers'];
				this.loadTeamMembers();
				this.hideSpinner();
			}.bind(this));
		}.bind(this));
	}

};