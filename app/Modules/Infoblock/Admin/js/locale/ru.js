Ext.define("Ext.locale.ru.Infoblock.view.Panel",
	{
	override: "Infoblock.view.Panel",
	title: "Инфоблоки"
	}
);

Ext.define("Ext.locale.ru.Infoblock.view.InfoblockUpdateWindow",
	{
	override: "Infoblock.view.InfoblockUpdateWindow",
	title: "Изменить инфоблок",

		fbar:
		[
			{
			text: "Изменить"
			},
			{
			text: "Очистить"
			},
			{
			text: "Отменить"
			}
		]
	}
);

Ext.define("Ext.locale.ru.Infoblock.view.InfoblockUpdateTab",
	{
	override: "Infoblock.view.InfoblockUpdateTab",

		items:
		[
			{
			title: "Основные данные"
			},
			{
			title: "HTML инфоблока"
			}
		]
	}
);

Ext.define("Ext.locale.ru.Infoblock.view.InfoblockGrid",
	{
	override: "Infoblock.view.InfoblockGrid",

		columns:
		[
			{
			header: 'ID'
			},
			{
			header: 'Название блока'
			},
			{
			header: 'Статус'
			}
		],
	buttonCreateText: "Добавить",
	buttonUpdateText: "Изменить",
	buttonDestroyText: "Удалить"
	}
);

Ext.define("Ext.locale.ru.Infoblock.view.InfoblockCreateWindow",
	{
		override: "Infoblock.view.InfoblockCreateWindow",
		title: "Добавить инфоблок",

		fbar:
		[
			{
			text: "Добавить"
			},
			{
			text: "Очистить"
			},
			{
			text: "Отменить"
			}
		]
	}
);

Ext.define("Ext.locale.ru.Infoblock.view.InfoblockCreateTab",
	{
	override: "Infoblock.view.InfoblockCreateTab",

		items:
		[
			{
			title: "Основные данные"
			},
			{
			title: "HTML инфоблока"
			}
		]
	}
);

Ext.define("Ext.locale.ru.Infoblock.view.field.InfoblockLabelInfoblockText",
	{
	override: "Infoblock.view.field.InfoblockLabelInfoblockText",

	fieldLabel: "Название блока:<span class='needsForm'>*</span>",
	msgError: "Название блока должно содержать от 1 до 255 символов!"
	}
);

Ext.define("Ext.locale.ru.Infoblock.store.Infoblock",
	{
	override: "Infoblock.store.Infoblock",

	error: "Ошибка!",
	msgError: "Произошла ошибка выполнения программы на сервере!"
	}
);

Ext.define("Ext.locale.ru.Infoblock.controller.Infoblock",
	{
	override: "Infoblock.controller.Infoblock",

	maskLoad: "Загрузка...",

	error: "Ошибка!",
	errorMsgServer: "Произошла ошибка выполнения программы на сервере!",

	questionDestroyTitle: "Удалить записи?",
	questionDestroyMsg: "Вы точно уверены, что хотите удалить эти записи?"
	}
);

Ext.define("Ext.locale.ru.Infoblock.controller.InfoblockCreate",
	{
	override: "Infoblock.controller.InfoblockCreate",

	maskLoad: "Загрузка...",

	error: "Ошибка!",
	errorMsgServer: "Произошла ошибка выполнения программы на сервере!",

	warningNoCorrectTitle: "Предупреждение!",
	warningNoCorrectMessage: "Некоторые поля в форме заполнены некорректно!",

	okTitle: "Данные добавлены!",
	okMsg: "Введенные вами данные были удачно добавлены!",

	errorMsgIsExist: "Вы не можете добавить инфоблок с таким названием, т.к. он уже есть в базе данных!"
	}
);


Ext.define("Ext.locale.ru.Infoblock.controller.InfoblockUpdate",
	{
	override: "Infoblock.controller.InfoblockUpdate",

	maskLoad: "Загрузка...",

	error: "Ошибка!",
	errorMsgServer: "Произошла ошибка выполнения программы на сервере!",

	warningNoCorrectTitle: "Предупреждение!",
	warningNoCorrectMessage: "Некоторые поля в форме заполнены некорректно!",

	okTitle: "Данные изменены!",
	okMsg: "Введенные вами данные были удачно изменены!",

	errorMsgIsExist: "Вы не можете добавить инфоблок с таким названием, т.к. он уже есть в базе данных!"
	}
);
