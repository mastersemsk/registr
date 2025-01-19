<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title>Формы запросов</title>
	</head>
	<body>
        <h3>Поиск организации по названию</h3>
            <form action="OrgName.php" method="post">
                Название <input name="org_name" required>
                <input type="hidden" name="token" value="wb7jxInR5m01N">
                <input type="submit" value="Отправить">
            </form>
        <h3>Информации об организации по её идентификатору</h3>
            <form action="OrgName.php" method="post">
            Идентификатор <input name="id" required>
                <input type="hidden" name="token" value="wb7jxInR5m01N">
                <input type="submit" value="Отправить">
            </form>
        <h3>Организации находящихся в здании</h3>
            <form action="OrgName.php" method="post">
            Улица,номер дома <input name="build" required>
                <input type="hidden" name="token" value="wb7jxInR5m01N">
                <input type="submit" value="Отправить">
            </form>
        <h3>Организации, по виду деятельности</h3>
            <form action="OrgName.php" method="post">
            <p><label for="actives">Вид деятельности</label>
		        <select id="actives" name="activ" required>
			        <option value="">Выбрать</option>
			        <option value="1"> Еда</option>
			        <option value="5"> - Мясная продукция</option>
			        <option value="6"> - Молочная продукция</option>
			        <option value="9"> - - Молоко</option>
			        <option value="13"> - - Сметана</option>
                    <option value="3"> Мебель</option>
					<option value="10"> - Офисная мебель</option>
                    <option value="2"> Автомобили</option>
					<option value="7"> - Грузовые</option>
					<option value="8"> - Легковые</option>
					<option value="11"> - - Запчасти</option>
					<option value="12"> - - Аксессуары</option>
					<option value="4"> Стройматериалы</option>
		        </select>
            </p>
                <input type="hidden" name="token" value="wb7jxInR5m01N">
                <input type="submit" value="Отправить">
            </form>
		<h3>Организации находящихся в радиусе от заданного адреса</h3>
            <form action="OrgName.php" method="post">
            <p><label for="latitude">Адрес организации</label>
				<input id="latitude" name="address" maxlength="150" required></p>
                <input type="hidden" name="token" value="wb7jxInR5m01N">
                <input type="submit" value="Отправить">
            </form>
    </body>
</html>