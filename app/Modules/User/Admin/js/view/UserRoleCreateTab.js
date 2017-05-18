Ext.define('User.view.UserRoleCreateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.User.view.UserRoleCreateTab',
	
		requires:
		[
		"User.view.UserRoleCreateForm",
		"User.view.UserRoleCreateAdminSectionGrid",
		"User.view.UserRoleCreatePageTree"
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
					xtype: "User.view.UserRoleCreateAdminSectionGrid"	
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