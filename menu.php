
<style>
    .menu a{
        color: #fff;
        background: #044fac;
        border-radius: 5px;
        height: 5px;
        font-size: 18px;
        text-decoration: none;
    }
    .menu a:hover{
        background: #b4145b;
        border-radius: 5px;
    }
    .one {
        padding: 10px 20px;
        text-align: center;
    }
    .one h1 {
        font-family: 'Righteous', cursive;
        position: relative;
        color: #3CA1D9;
        display: inline-block;
        border-top: 2px solid;
        border-bottom: 2px solid;
        font-size: 3em;
        padding: 11px 60px;
        margin: 0;
        line-height: 1;
    }
    .one h1:before, .one h1:after {
        content: "";
        position: absolute;
        top: 0;
        width: 30px;
        height: 100%;
        border-left: 2px solid;
        border-right: 2px solid;
        background: repeating-linear-gradient(180deg, transparent, transparent 2px, #3CA1D9 2px, #3CA1D9 4px);
    }
    .one h1:before {left: 0;}
    .one h1:after {right: 0;}
    @media (max-width: 420px) {
        .one h1 {font-size: 2em;}
    }
    p {
        font-family: "Times New Roman";
        font-weight: 600;
    }
    .c {
        border: 1px solid #333; /* Рамка */
        display: inline-block;
        padding: 5px 15px; /* Поля */
        text-decoration: none; /* Убираем подчёркивание */
        color: #ffffff; /* Цвет текста */
        background: #008000;
    }
    .c:hover {
        box-shadow: 0 0 5px rgba(0,0,0,0.3); /* Тень */
        background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
        color: #a00;
    }
    .query a{
        border: 1px solid #333; /* Рамка */
        display: inline-block;
        padding: 5px 15px; /* Поля */
        text-decoration: none; /* Убираем подчёркивание */
        color: #ffffff; /* Цвет текста */
        background: #008000;
        border-radius: 5px;
    }
    .query a:hover {
        box-shadow: 0 0 5px rgba(0,0,0,0.3); /* Тень */
        background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
        color: #a00;
    }
</style>



<hr>
<div class="menu">
    <a href="?task=product_list">Товары</a>
    <a href="?task=marketer_list">Продавцы</a>
    <a href="?task=buyer_list" >Покупатели</a>
    <a href="?task=owner_list" >Владельцы</a>
    <a href="?task=shipper_list" >Поставщики</a>
    <a href="?task=sales_list" >Продажи</a>
    <a href="?task=dep_list" >Отделы</a>
    <a href="?task=magazine_list" >Магазины</a>
    <a href="?task=sh_list" >Склад</a>
    <a href="?task=request_list" >Список запросов</a>
    <a href="?task=migration" >Миграций</a>
    <br>
</div>
<hr>
