Ext.define('User.view.UserTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.User.view.UserTab',
	
	name: "User",
	margin: 5,
	region: "center",
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
		items:
		[
			{
			title: "Пользователи",
			iconCls: "icon_User_Account_small",
			layout: "fit",
			id: "Account",
				items:
				[
					{
					xtype: "User.view.UserAccountGrid"	
					}
				]
			},
			{
			title: "Группы",
			iconCls: "icon_User_Group_small",
			layout: "fit",
			id: "Group",
				items:
				[
					{
					xtype: "User.view.UserGroupGrid"	
					}
				]
			},
			{
			title: "Роли",
			iconCls: "icon_User_Role_small",
			layout: "fit",
			id: "Role",
				items:
				[
					{
					xtype: "User.view.UserRoleGrid"	
					}
				]
			},
			{
			title: "Блокированные IP",
			iconCls: "icon_User_BlockIp_small",
			layout: "fit",
			id: "BlockIp",
				items:
				[
					{
					xtype: "User.view.UserBlockIpGrid"	
					}
				]
			}
		]
	}
);