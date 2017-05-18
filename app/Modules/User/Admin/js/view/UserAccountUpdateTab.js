Ext.define('User.view.UserAccountUpdateTab', 
	{
    extend: "User.view.UserAccountCreateTab",
	alias: 'widget.User.view.UserAccountUpdateTab',

		requires:
		[
		"User.view.UserAccountCreateTab"
		],
		
		items:
		[
			{
			title: "Данные для входа",
			layout: "fit",
			itemId: "tab_1",
				items:
				[
					{
					xtype: "User.view.UserAccountCreateFormEnter"	
					}
				]
			},
			{
			title: "Личные данные",
			layout: "fit",
			itemId: "tab_2",
				items:
				[
					{
					xtype: "User.view.UserAccountCreateFormPersonal"	
					}
				]
			},	
			{
			title: "Адрес",
			layout: "fit",
			itemId: "tab_3",
				items:
				[
					{
					xtype: "User.view.UserAccountCreateFormAdress"	
					}
				]
			},
			{
			title: "Паспорт",
			layout: "fit",
			itemId: "tab_4",
				items:
				[
					{
					xtype: "User.view.UserAccountCreateFormPasport"	
					}
				]
			},	
			{
			title: "Организация",
			layout: "fit",
			itemId: "tab_5",
				items:
				[
					{
					xtype: "User.view.UserAccountCreateFormFirma"	
					}
				]
			},	
			{
			title: "Изображение",
			layout: "fit",
			itemId: "tab_6",
				items:
				[
					{
					xtype: "User.view.UserAccountUpdateImagePanel"
					}
				]
			},
			{
			title: "Назначемые группы",
			layout: "fit",
			itemId: "tab_7",
				items:
				[
					{
					xtype: "User.view.UserAccountCreateGroupGrid"	
					}
				]
			}
		]
	}
);