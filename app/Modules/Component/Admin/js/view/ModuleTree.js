Ext.define('Component.view.ModuleTree',
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Component.view.ModuleTree',
	
	name: "ModuleTree",
	store: "ModuleTree",
		
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "Component.view.ComponentGrid",
			enableDrag: false
			}
		},
		
		selModel:
		{
		xtype: "treemodel", 
		mode: "SINGLE"
		},
	
	canDeleteFirstNode: false,
	canUpdateFirstNode: false,
	
	filter: true,
	
	region: 'west',
	width: 280,
	title: "Модули",
	split: true,
	rootVisible: true,
	collapsible: true,
	margin: '5 0 5 5',

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