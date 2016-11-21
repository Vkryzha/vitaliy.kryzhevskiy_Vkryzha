/**
 * Created by Summer on 21.11.2016.
 */

(function () {
    



    var vhx = [];
    vhx[0] = document.getElementById('x0');
    vhx[1] = document.getElementById('x1');
    vhx[2] = document.getElementById('x2');
    vhx[3] = document.getElementById('x3');
    vhx[4] = document.getElementById('x4');
    vhx[5] = document.getElementById('x5');

    var vhy = [];
    vhy[0] = document.getElementById('y0');
    vhy[1] = document.getElementById('y1');
    vhy[2] = document.getElementById('y2');
    vhy[3] = document.getElementById('y3');
    vhy[4] = document.getElementById('y4');
    vhy[5] = document.getElementById('y5');

    var mass1 = vhx;  //отримуємо набір точок x
    var mass2 = vhy;  //отримуємо набір точок y
    var n = 6;      //допоміжна змінна
    var rizn  = [];  // матриця різниць
    var krok = vhx[1]-vhx[0];   //ширина кроку по х


    for(var  i=0;  i<n;  i++)  //обнуляємо матрицю різниць
    {
        rizn[i]=[];
        for(var j=0; j<n-2; j++)
        {
            rizn[i][j]= 0;
        }
    }

    for( i=0; i<n-1; i++) //обчислюємо різниці першого порядку
    {
        rizn[i][0]= vhy[i+1] - vhy[i];
    }

    for( j=1; j<n-3;  j++)   //знаходимо значення різниць ще двох порядків
    {
        for( i=0; i<=n-j-2; i++)  //кількість різниць з кожним порядком зменшуватиметься на 1
        {
            rizn[i][j]=rizn[i+1][j-1]-rizn[i][j-1];
            if(rizn[4][2]) break;
        }
    }

    ////перша формула Гауса - інтерполяція вперед

    var x = vhx[0];
    var tx = [];   //для зберігання координат точок за першою формулою
    var ty = [];

    for(var ix=0; ix<(6*2)+1; ix++)
    {
        if(ix!=0)
        {
            x=x+0.01;
        }

        i=0;
        while(vhx[i]<x)
        {
            i++;   //знаходимо індекс елемента зліва від х
        }

        var p = (x-vhx[i])/krok;
        var y1 = p*rizn[i][0];
        var y2 = p*(p-1)*rizn[i-1][1]/2;
        var y3 = p*(p-1)*(p+1)*rizn[i-1][2]/6;
        var y4 = p*(p-1)*(p+2)*(p-2)*rizn[i-2][3]/24;
        var yp = vhy[i]+y1+y2+y3+y4;

        tx[ix] = x;
        ty[ix] = yp;
    }

    ////друга формула Гауса - інтерполяція назад

    x=vhx[6-1];
    var tx1 = [];
    var ty1 = [];

    for(ix=0; ix<(6*2)+1; ix++)
    {
        if(ix!=0)
        {
            x=x-0.01;
        }

        i =0;
        do{
            i++;   //знаходимо індекс елемента справа від х
        } while(vhx[i]<x);

        p = (x-vhx[i])/krok;
        y1 = p*rizn[i-1][0];
        y2 = p*(p-1)*rizn[i-1][1]/2;
        y3 = p*(p-1)*(p+1)*rizn[i-2][2]/6;
        y4 = p*(p-1)*(p+1)*(p-2)*rizn[i-2][3]/24;
        yp = vhy[i]+y1+y2+y3+y4;

        tx1[ix] = x;
        ty1[ix] = yp;
    }
    console.log(typeof 1);

})();
