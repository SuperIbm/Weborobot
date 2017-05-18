Ext.define("Ext.locale.en.Admin.view.ux.ComboBoxStatus",
	{
	override: "Admin.view.ux.ComboBoxStatus",

	emptyText: "Select status",
	fieldLabel: "Status:<span class='needsForm'>*</span>",
	errorMsg: "You have to select status!"
	}
);

Ext.define("Ext.locale.en.Admin.view.ux.GridPanel",
	{
	override: "Admin.view.ux.GridPanel",

	maskLoad: "Loading...",
	error: "Error!",
	errorMsgServer: "The server error!"
	}
);

Ext.define("Ext.locale.en.Admin.view.ux.MapPicker",
	{
	override: "Admin.view.ux.MapPicker",

	invalidText: "It's not correct coordinates. The coordinates have to contain two number that separate comma!",
	windowTitle: "Select coordinate",
	balloonContentBody: "Coordinate"
	}
);

Ext.define("Ext.locale.en.Admin.view.ux.TreePanel",
	{
	override: "Admin.view.ux.TreePanel",

	maskLoad: "Loading...",
	error: "Error!",
	errorMsgServer: "The server error!"
	}
);

Ext.define("Ext.locale.en.Admin.view.AppBreadCrumb",
	{
	override: "Admin.view.AppBreadCrumb",

	index: "Home"
	}
);

Ext.define("Ext.locale.en.Admin.view.AppDesctop",
	{
	override: "Admin.view.AppDesctop",

	title: "Content"
	}
);


Ext.define("Ext.locale.en.Admin.view.AppHeader",
	{
	override: "Admin.view.AppHeader",

		items:
		[
			{

			},
			"->",
			{
			text: "Home"
			},
			{
			text: "Menu"
			},
			{
			text: "Clean cache"
			},
			{
			text: "Exit"
			}
		]
	}
);

Ext.define("Ext.locale.en.Admin.view.AppMenu",
	{
	override: "Admin.view.AppMenu",

	title: "Menu"
	}
);

Ext.define("Ext.locale.en.Admin.view.AppMenuLeft",
	{
	override: "Admin.view.AppMenuLeft",

	exit: "Exit"
	}
);

Ext.define("Ext.locale.en.Admin.view.AppRoot",
	{
	override: "Admin.view.AppRoot",

	addWidget: "Add widget"
	}
);

Ext.define("Ext.locale.en.Admin.view.EnterForm",
	{
	override: "Admin.view.EnterForm",

		items:
		[
			{
			fieldLabel: "Login",
			msgError: "The field have to contain the string from 4 to 25 length!"
			},
			{
			fieldLabel: "Password",
			msgError: "The field have to contain the string from 6 to 25 length!"
			},
			{
			fieldLabel: "Remember"
			}
		]
	}
);

Ext.define("Ext.locale.en.Admin.view.EnterWindow",
	{
	override: "Admin.view.EnterWindow",

		fbar:
		[
			{
			text: "Enter"
			},
			{
			text: "Reset"
			}
		]
	}
);