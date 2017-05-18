Ext.define('User.view.UserAccountCreateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.User.view.UserAccountCreateTab',
	
		requires:
		[
		"User.view.UserAccountCreateFormEnter",
		"User.view.UserAccountCreateFormPersonal",
		"User.view.UserAccountCreateFormAdress",
		"User.view.UserAccountCreateFormPasport",
		"User.view.UserAccountCreateFormFirma",
		"User.view.UserAccountCreateFormImage",
		"User.view.UserAccountCreateGroupGrid"
		],
	
	name: "User",
	padding: 5,
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
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
					xtype: "User.view.UserAccountCreateFormImage"	
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