Ext.define("Admin.view.ux.PanelAnimate",
	{
	extend: "Ext.panel.Panel",
	xtype: 'panelAnimate',
	alias: 'widget.panelAnimate',
	
	cls: 'x-portal',
    bodyCls: 'x-portal-body',
    defaultType: 'panelColumnAnimate',
    scrollable: true,
    manageHeight: false,

		initComponent: function()
		{
			this.layout =
			{
			type: 'column'
			};
		
		this.callParent();		
			
			this.addStateEvents
			(
				[
				"validatedrop",
				"beforedragover",
				"dragover",
				"beforedrop",
				"drop"
				]
			);
		},
		
		beforeLayout: function()
		{
		var items = this.layout.getLayoutItems(),
		len = items.length,
		firstAndLast = ['x-portal-column-first', 'x-portal-column-last'],
		i, item, last;
		
			for(i = 0; i < len; i++)
			{
			item = items[i];
			item.columnWidth = 1 / len;
			last = (i == len-1);
		
				if(!i)
				{
					if (last)
					{
					item.addCls(firstAndLast);
					}
					else
					{
					item.addCls('x-portal-column-first');
					item.removeCls('x-portal-column-last');
					}
				}
				else if(last)
				{
				item.addCls('x-portal-column-last');
				item.removeCls('x-portal-column-first');
				}
				else
				{
				item.removeCls(firstAndLast);
				}
			}
		
		return this.callParent(arguments);
		},
		
		initEvents: function()
		{
		this.callParent();
		this.dd = new Admin.view.ux.PanelAnimateDropZone(this, this.dropConfig);
		}
	}	
);


