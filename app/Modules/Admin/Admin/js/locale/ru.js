Ext.define("Ext.locale.ru.Admin.view.ux.ComboBoxStatus",
	{
	override: "Admin.view.ux.ComboBoxStatus",
	emptyText: "Выберите статус",
	fieldLabel: "Статус:<span class='needsForm'>*</span>",
	errorMsg: "Вы должны определить статус!"
	}
);

Ext.define("Ext.locale.ru.Admin.view.ux.GridPanel",
	{
	override: "Admin.view.ux.GridPanel",

	maskLoad: "Загрузка...",
	error: "Ошибка!",
	errorMsgServer: "Произошла ошибка выполнения программы на сервере!"
	}
);

Ext.define("Ext.locale.ru.Admin.view.ux.MapPicker",
	{
	override: "Admin.view.ux.MapPicker",

	invalidText: "Это некорректная координата, она должна состоять из двух чисел разделенные запятой!",
	windowTitle: "Выберите координату",
	balloonContentBody: "Координата"
	}
);

Ext.define("Ext.locale.ru.Admin.view.AppBreadCrumb",
	{
	override: "Admin.view.AppBreadCrumb",

	index: "Главная"
	}
);

Ext.define("Ext.locale.ru.Admin.view.AppDesctop",
	{
	override: "Admin.view.AppDesctop",

	title: "Контент"
	}
);

Ext.define("Ext.locale.ru.Admin.view.AppHeader",
	{
	override: "Admin.view.AppHeader",

		items:
		[
			{

			},
			"->",
			{
			text: "Домой"
			},
			{
			text: "Меню"
			},
			{
			text: "Очистить кеш"
			},
			{
			text: "Выход"
			}
		]
	}
);

Ext.define("Ext.locale.ru.Admin.view.AppMenu",
	{
	override: "Admin.view.AppMenu",

	title: "Меню"
	}
);

Ext.define("Ext.locale.ru.Admin.view.AppMenuLeft",
	{
	override: "Admin.view.AppMenuLeft",

	exit: "Выход"
	}
);

Ext.define("Ext.locale.ru.Admin.view.AppRoot",
	{
	override: "Admin.view.AppRoot",

	addWidget: "Добавить виджет"
	}
);

Ext.define("Ext.locale.ru.Admin.view.EnterForm",
	{
	override: "Admin.view.EnterForm",

		items:
		[
			{
			fieldLabel: "Логин",
			msgError: "Логин должен содержать от 4 до 25 символов!"
			},
			{
			fieldLabel: "Пароль",
			msgError: "Пароль должен содержать от 6 до 25 символов!"
			},
			{
			fieldLabel: "Запомнить"
			}
		]
	}
);

Ext.define("Ext.locale.ru.Admin.view.EnterWindow",
	{
	override: "Admin.view.EnterWindow",

		fbar:
		[
			{
			text: "Войти"
			},
			{
			text: "Очистить"
			}
		]
	}
);