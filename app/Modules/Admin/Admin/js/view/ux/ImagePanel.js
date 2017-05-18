Ext.define("Admin.view.ux.ImagePanel",
	{
	extend: "Ext.panel.Panel",
	xtype: 'imagePanel',
	alias: 'widget.imagePanel',
	
	layout: "fit",
	bodyStyle: "padding: 15px; text-align: center;",
	html: "<img src='" + Ext.BLANK_IMAGE_URL + "'>",
		
		initComponent: function()
		{
		this.callParent();
		var thisObj = this;			
		this.store = Ext.data.StoreManager.lookup(this.store || 'ext-empty-store');
		
			this.store.on("load",
				function(store, records, successful, eOpts)
				{
					if(records.length) thisObj.loadRecord(records[0]);
					else thisObj.cleanImage();	
				}
			);
			
			if(this.buttonCreate) createDockedTop = true;
			if(this.buttonDestroy) createDockedTop = true;
			
			if(createDockedTop)
			{
			var id = "top_" + this.getId();
			
				if(!this.getDockedComponent(id))
				{
					this.addDocked
					(
						{
						xtype: 'toolbar',
						id: id,
						dock: 'top'
						},
					0
					);
				}
				
			this.getDockedComponent(id).add("->");
			
				if(this.buttonCreate)
				{								
					this._ButtonCreate = new Ext.button.Button
					(
						Ext.apply
						(
							{
							action: 'create',
							iconCls: this.buttonCreate.iconCls == undefined ? "icon_create" : this.buttonCreate.iconCls
							},
						this.buttonCreate
						)
					);
					
				this.getDockedComponent(id).add(this._ButtonCreate);
				}	
				
				if(this.buttonDestroy)
				{								
					this._ButtonDestroy = new Ext.button.Button
					(
						Ext.apply
						(
							{
							action: 'destroy',
							disabled: true,
							iconCls: this.buttonDestroy.iconCls == undefined ? "icon_delete" : this.buttonDestroy.iconCls
							},
						this.buttonDestroy
						)
					);
					
				this.getDockedComponent(id).add(this._ButtonDestroy);
				}
			}
		},
		getStore: function()
		{
		return this.store;
		},
		setId: function(id)
		{
		this.getStore().getProxy().setExtraParam("id", id);
		return this;	
		},
		loadRecord: function(record)
		{
		this._record = record;
		this.setImage(record.get("path"), record.get("width"), record.get("height"));
		return this;
		},
		getRecord: function()
		{
		return this._record;
		},
		setImage: function(path, width, height)
		{
		this.getButtonDestroy().setDisabled(false);
		this.setHtml("<img src='" + path + "' width='" + width + "' height='" + height + "' />");
		return this;	
		},
		setImageByArray: function(arr)
		{
			if(arr)
			{
			this.getButtonDestroy().setDisabled(false);
			this.setHtml("<img src='" + arr["path"] + "' width='" + arr["width"] + "' height='" + arr["height"] + "' />");
			}
			else this.getButtonDestroy().setDisabled(true);

		return this;
		},
		setHtml: function(html)
		{
			if(html) this.getButtonDestroy().setDisabled(false);
			else this.getButtonDestroy().setDisabled(true);
		
		return this.callParent(new Array(html));
		},
		cleanImage: function()
		{
		this.getButtonDestroy().setDisabled(true);
		this.setHtml();
		return this;	
		},
		getButtonCreate: function()
		{
		return this._ButtonCreate;
		},
		getButtonDestroy: function()
		{
		return this._ButtonDestroy;
		}
	}	
);