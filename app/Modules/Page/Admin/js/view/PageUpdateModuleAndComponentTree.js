Ext.define('Page.view.PageUpdateModuleAndComponentTree',
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Page.view.PageUpdateModuleAndComponentTree',
	
	store: 'PageUpdateModuleAndComponentTree',
	name: 'PageUpdateModuleAndComponentTree',
	
		selModel:
		{
		xtype: "treemodel", 
		mode: "MULTI"
		},
	selType: "rowmodel",
	
	canDeleteFirstNode: false,
	
	region: 'center',
	split: true,
		root:
		{
		allowDrop: false,
		id: -1
		},
		
		margins: 
		{
		top: 5,
		right: 5,
		bottom: 5,
		left: 0
		},
		
	title: "Доступные компоненты",
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "Page.view.PageUpdatePageComponentTree",
			enableDrop: false,
			copy: true
			}
		},
		
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			}
		]
	}
);