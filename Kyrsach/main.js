(function () {

    var vhx = [];
    vhx[0] = document.getElementById('x0').value;   //отримуємо набір точок x
    vhx[1] = document.getElementById('x1').value;
    vhx[2] = document.getElementById('x2').value;
    vhx[3] = document.getElementById('x3').value;
    vhx[4] = document.getElementById('x4').value;
    vhx[5] = document.getElementById('x5').value;

    var vhy = [];
    vhy[0] = document.getElementById('y0').value;   //отримуємо набір точок y
    vhy[1] = document.getElementById('y1').value;
    vhy[2] = document.getElementById('y2').value;
    vhy[3] = document.getElementById('y3').value;
    vhy[4] = document.getElementById('y4').value;
    vhy[5] = document.getElementById('y5').value;

    for(var t = 0; t<6; t++){   //перетворюємо із string into number
        vhy[t] = Number(vhy[t]);
        vhx[t] = Number(vhx[t]);
    }





})();