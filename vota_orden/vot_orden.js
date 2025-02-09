// JavaScript Document
var showSelectedCandidates = function(type) {
  var selected = 0;
  var list_selected = $("#table-" + type + "-v").find('.candidates');
  var items = list_selected.find('li');
  if (!items.length) {
    $("#confirm-" + type).hide();
    return 0;
  }
  var list_confirm = $("#confirm-" + type).find('ul');
  list_confirm.html("");
  for (var i = 0, l = items.length; i < l; i++) {
    var item = $(items[i]);
    if (item.data('id') == '0') {
      break;
    } else {
      list_confirm.append("<li class='list-group-item'>" + item.data('position') + " " + item.find('.name').html() + "</li>");
      selected++;
    }
  }
  return selected;
};

var getVotes = function(type) {
  var result = [];
  var list_selected = $("#table-" + type + "-v").find('.candidates');
  var items = list_selected.find('li');
  for (var i = 0, l = items.length; i < l; i++) {
    var item = $(items[i]);
    if (item.data('id') == '0') {
      break;
    } else {
      result.push([item.data('position'), item.data('id')]);
    }
  }
  return result;
};

var sendVote = function(data) {
  $.ajax({
    url: "func.inc.php",
    type: "POST",
    data: data,
    beforeSend: function(){
      $("alert-error").find('div').html('');
      $("#confirm").fadeTo("slow", 0.3);
    },
    error: function(){
      $("#confirm").fadeTo("fast", 1);
      $('#confirmvote').prop("disabled", false);
      $("#alert-error").show();
      $("#alert-error").find('div').html('Problema de comunicación con el servidor. Intentelo de nuevopasados unos minutos.');
    },
    success: function(data) {
      var result = data.trim().split("#");
      if (result[0] == 'OK'){
        $("#votacion").hide("slow");
        $('#respuestaOK').find('div').html(result[1]);
        $('#respuestaOK').show();
      }else {
		//alert("error"); //STG: Lo comento..
        $("#confirm").fadeTo("fast", 1);
        $('#confirmvote').prop("disabled", false);
        $("#alert-error").show();
        $("#alert-error").find('div').html("<img src=\"../imagenes/iProhibido.gif\"> Se ha producido un error: " + result[1]);
      }
    }
  });
};


$(document).ready(function() {
  $(".add-candidate").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var candidat = $(this).parent();
    var type = candidat.data('type');
    var list_selected = $("#table-" + type + "-v").find('.candidates');
    var items = list_selected.find('li');
    var position = 1;
    for (var i = 0, l = items.length; i < l; i++) {
      var item = $(items[i]);
      if (item.data('id') == '0') {
        item.find('.name').html(candidat.find('.name').html());
        item.data('id', candidat.data('id'));
        item.data('type', candidat.data('type'));
        item.removeClass('empty');
        position = parseInt(item.data('position')) + 1;
        candidat.hide();
        break;
      }
    }
    // update position at buttons
    if (position > items.length) {
      candidat.parent().find('.add-candidate').each(function() {
        $(this).prop("disabled", true);
      });
    } else {
      candidat.parent().find('.position').each(function() {
        $(this).html(position);
      });
    }
  });

  $(".del-candidate").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var item = $(this).parent().parent();
    var id_candidat = item.data('id');
    if (!id_candidat) {
      return;
    }
    var type_candidat = item.data('type');
    var candidats = $("#table-" + type_candidat + "-c").find('.candidates').find('li');
    var i, l;
    for (i = 0, l = candidats.length; i < l; i++) {
      var candidat = $(candidats[i]);
      if (candidat.data('id') == id_candidat) {
        candidat.show();
        item.data('id', "0");
        item.find('.name').html("");
        item.addClass('empty');
        break;
      }
    }
    // update selected items (check if empty positions)
    var items = $("#table-" + type_candidat + "-v").find('.candidates').find('li');
    var completed = 0;
    var last_empty = -1;
    for (i = 0, l = items.length; i < l; i++) {
      item = $(items[i]);
      if (item.data('id') == '0') {
        last_empty = i;
      } else {
        completed++;
        if (last_empty > -1) {
          // move up this item
          var last_item = $(items[last_empty]);
          last_item.find('.name').html(item.find('.name').html());
          last_item.data('id', item.data('id'));
          last_item.data('type', item.data('type'));
          last_item.removeClass('empty');
          // empty this item
          item.find('.name').html("");
          item.data('id', "0");
          item.addClass('empty');
          last_empty = i;
        }
      }
    }
    // update position at buttons    
    if (completed > items.length - 1) {
      candidats.find('.add-candidate').each(function() {
        $(this).prop("disabled", true);
      });
    } else {
      candidats.find('.add-candidate').each(function() {
        $(this).prop("disabled", false);
      });
      candidats.find('.position').each(function() {
        $(this).html(completed + 1);
      });
    }
  });


  $(".up-candidate").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var item = $(this).parent().parent();
    var id_candidat = item.data('id');
    if (!id_candidat) {
      return;
    }
    var prev_item = item.prev();
    var prev_name = prev_item.find('.name').html();
    var prev_id = prev_item.data('id');
    prev_item.find('.name').html(item.find('.name').html());
    prev_item.data('id', item.data('id'));
    item.find('.name').html(prev_name);
    item.data('id', prev_id);
  });


  $(".down-candidate").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var item = $(this).parent().parent();
    var id_candidat = item.data('id');
    if (!id_candidat) {
      return;
    }
    var next_item = item.next();
    var next_name = next_item.find('.name').html();
    var next_id = next_item.data('id');
    if (next_id != 0) {
      next_item.find('.name').html(item.find('.name').html());
      next_item.data('id', item.data('id'));
      item.find('.name').html(next_name);
      item.data('id', next_id);
    }
  });

  // buttons
  $("#cancelvote").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    location.href = '../votacion/inicio.php';
  });
  $("#backlist").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    location.href = '../votacion/inicio.php';
  });

  $("#vote").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    // show selected candidates
    var men = showSelectedCandidates('men');
    var women = showSelectedCandidates('women');
    $("#alert-error").hide();
    $("#alert-vot-nul").hide();
    $("#alert-vot-blanc").hide();
    if (men + women == 0) {
      $("#confirm-blanc").attr('checked', false);
      $("#alert-vot-blanc").show();
    } else {
      if ($("#table-men-v").length > 0 && $("#table-women-v").length > 0){
        var ratio_men = men / (men + women);
        var ratio_women = women / (men + women);
        if (ratio_men > 0.6 || ratio_men < 0.4) {
          $("#alert-vot-nul").find('span.men').html(Math.round(ratio_men * 100));
          $("#alert-vot-nul").find('span.women').html(Math.round(ratio_women * 100));
          $("#confirm-nul").attr('checked', false);
          $("#alert-vot-nul").show();
        }
      }
    }
    if ($("#table-men-v").length == 0 || $("#table-women-v").length == 0){
        $("#confirm-men").find("h3").hide();
        $("#confirm-women").find("h3").hide();
		$("#confirm-neutro").find("h3").hide();
    }
    $("#selection").hide();
    $("#confirm").show();
	$("#confirm-neutro").find("h3").hide();
  });

  $("#backtovote").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $("#confirm").hide();
    $("#selection").show();
  });

  $("#confirmvote").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).prop("disabled", true);
    var men = getVotes('men');
    var women = getVotes('women');
    var vot_blanc = false;
    var vot_nul = false;    
    if (men.length + women.length == 0) {
      if (!$("#confirm-blanc").is(':checked')) {
        alert('Marque la casilla para confirmar el voto en blanco.');
        $(this).prop("disabled", false);
        return;
      } else {
        vot_blanc = true;
      }
    }
    if ($("#table-men-v").length > 0 && $("#table-women-v").length > 0){
      var ratio_men = men.length / (men.length + women.length);
      if (ratio_men > 0.6 || ratio_men < 0.4) {
        if (!$("#confirm-nul").is(':checked')) {
          alert('Marque la casilla para confirmar el voto nulo');
          $(this).prop("disabled", false);
          return;
        } else {
          vot_nul = true;
        }
      }
    }
    // OK. Send Vote
    var valores = "";
    for (var i = 0, l = men.length; i < l; i++) {
      valores += men[i][0] + "," + men[i][1] + ";";
    }
    for (var j = 0, lj = women.length; j < lj; j++) {
      valores += women[j][0] + "," + women[j][1] + ";";
    }
	
	
    var clave_seg = $("#clave_seg").val();
    var id_vot = $("#id_vot").attr("value");
    var id_provincia = $("#id_provincia").attr("value");
    var id_grupo_trabajo = $("#id_grupo_trabajo").attr("value");
    var demarcacion = $("#demarcacion").attr("value");
    var id_ccaa = $("#id_ccaa").attr("value");
	var mixto = $("#mixto").attr("value");
	var recuento = $("#recuento").attr("value");
	var id_votante = $("#id_votante").attr("value"); //STG: Nuevo, para que un admin pueda votar presencialmente por otro votante, quien podrá luego comprobar su voto con su clave secreta.
	//var campotexto_adicional = document.getElementById("campotexto_adicional").value;
    //var cadena = 'add_usuario=1&id_vot=' + id_vot + '&id_provincia=' + id_provincia + '&id_grupo_trabajo=' + id_grupo_trabajo + '&id_ccaa=' + id_ccaa + '&clave_seg=' + clave_seg + '&demarcacion=' + demarcacion + '&recuento=' + recuento + '&valores=' + valores + '&mixto=' + mixto + '&campotexto_adicional=' + campotexto_adicional;
	var cadena = 'add_usuario=1&id_vot=' + id_vot + '&id_provincia=' + id_provincia + '&id_grupo_trabajo=' + id_grupo_trabajo + '&id_ccaa=' + id_ccaa + '&clave_seg=' + clave_seg + '&demarcacion=' + demarcacion + '&recuento=' + recuento + '&valores=' + valores + '&mixto=' + mixto;
    if (id_votante) {
      cadena += '&id_votante=' + id_votante;
    }	
    if (vot_blanc) {
      cadena += '&blanco=true';
    }
    if (vot_nul) {
      cadena += '&nulo=true';
    }
    sendVote(cadena);
    return;
  });

});