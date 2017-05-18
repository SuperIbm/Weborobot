Ext.define('User.view.UserRoleUpdateTab', 
	{
    extend: "User.view.UserRoleCreateTab",
	alias: 'widget.User.view.UserRoleUpdateTab',

		requires:
		[
		"User.view.UserRoleCreateTab",
		"User.view.UserRoleUpdateAdminSectionGrid"
		],
		
		items:
		[
			{
			title: "Основные денные",
			layout: "fit",
			itemId: "tab_1",
				items:
				[
					{
					xtype: "User.view.UserRoleCreateForm"	
					}
				]
			},
			{
			title: "Доступ к разделам административной системы",
			layout: "fit",
			itemId: "tab_2",
				items:
				[
					{
					xtype: "User.view.UserRoleUpdateAdminSectionGrid"	
					}
				]
			},
			{
			title: "Доступ к редактированию структуры сайта",
			layout: "fit",
			itemId: "tab_3",
				items:
				[
					{
					xtype: "User.view.UserRoleCreatePageTree"
					}
				]
			}
		]
	}
);