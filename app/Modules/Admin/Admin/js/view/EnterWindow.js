Ext.define('Admin.view.EnterWindow', 
	{
    extend: 'Ext.Window',
	alias: 'widget.Admin.view.EnterWindow',
	
	width: 400,
	title: "Вход в административную систему",
	closable: false,
	resizable: false,
	iconCls: "icon_enter",
	modal: true,
	renderTo: Ext.getBody(),
	constrain: true,
		tbar:
		[
			{
			xtype: "Admin.view.EnterForm"
			}
		],
		initComponent: function()
		{
		this.renderTo = Admin.getApplication().Enter.getViewport().getEl();

			this.fbar =
			[
				{
				xtype: "button",
				text: this.fbar[0].text,
				action: "send"
				},
				{
				xtype: "button",
				text: this.fbar[1].text,
				action: "reset"
				}
			];
			
		this.callParent();
		}
	}
);