Ext.define('User.view.UserGroupCreateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.User.view.UserGroupCreateTab',
	
		requires:
		[
		"User.view.UserGroupCreateForm",
		"User.view.UserGroupCreateUserRoleGrid",
		"User.view.UserGroupCreatePageTree"
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
			title: "Основные данные",
			layout: "fit",
			itemId: "tab_1",
				items:
				[
					{
					xtype: "User.view.UserGroupCreateForm"	
					}
				]
			},
			{
			title: "Используемые роли",
			layout: "fit",
			itemId: "tab_2",
				items:
				[
					{
					xtype: "User.view.UserGroupCreateUserRoleGrid"	
					}
				]
			},
			{
			title: "Доступ к страницам сайта",
			layout: "fit",
			itemId: "tab_3",
				items:
				[
					{
					xtype: "User.view.UserGroupCreatePageTree"	
					}
				]
			}
		]
	}
);