Ext.define('Admin.view.EnterViewport', 
	{
    extend: 'Ext.container.Viewport',
	
		requires:
		[
		"Admin.view.EnterWindow",
		"Admin.view.EnterForm"
		], 
	
	border: false,
	layout: "border",
	
	minWidth: 450,
	minHeight: 450,
	
		destroy: function()
		{
		Admin.getApplication().Enter.getWindow().destroy();
		Admin.getApplication().Enter.isReady(false);
		
		Admin.getApplication().Section.setSection();
		Admin.getApplication().Section.setMenuCurrent();
		
		this.callParent();
		},
	}
);