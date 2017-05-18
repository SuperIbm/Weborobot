Ext.define('User.view.UserRoleCreatePageTree', 
	{
    extend: 'Page.view.PageTree',
	alias: 'widget.User.view.UserRoleCreatePageTree',
	
		requires:
		[
		'Page.view.PageTree'
		],
	
	name: "User",
	border: true,
	store: "PageSelect",
	
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			},
			{
			type: 'expand',
			tooltip: 'Развернуть',
			itemId: 'expand'
			},
			{
			type: 'collapse',
			tooltip: 'Свернуть',
			itemId: 'collapse'
			}
		]
	}
);