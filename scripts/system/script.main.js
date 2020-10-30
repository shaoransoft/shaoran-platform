$(function(e) {
  //document.addEventListener('contextmenu', e => e.preventDefault());

  $('tr.row-link').dblclick(function() {
    var href = $(this).data('href');
    if (href != null) window.location.href = href;
  });

  $('ul.nav-pills a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('ul.nav-pills > li > a').on('shown.bs.tab', function(e) {
    var id = $(e.target).attr('href').substr(1);
    window.location.hash = id;
  });
  var hash = window.location.hash;
  //$('ul.nav-pills a[href="' + hash + '"]').tab('show');

  $('.wrap .content').css({ marginTop: $('.wrap .header .navbar').height() + 16 + 'px' });
});

Number.prototype.number_format = function(c, d, t) {
  var n = this,
  c = isNaN(c = Math.abs(c)) ? 2 : c,
  d = d == undefined ? "." : d,
  t = t == undefined ? "," : t,
  s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

String.prototype.format = function() {
  a = this;
  for (k in arguments) {
    a = a.replace("{" + k + "}", arguments[k]);
  }
  return a;
}

function ucfrist(s) {
  return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase();
}

function s0(n, l = 2) {
  z = "";
  for (i = 0; i < (l - n.toString().length); i++) { z += "0"; }
  return z + n;
}
