Ext.define('ModuleTemplate.controller.Module',
	{
	extend: 'Ext.app.Controller',
	
	id: "Module",
	
	views: ["ModuleTree"],
	models: ["ModuleTree"],
	stores: ["ModuleTree"],
	
	idOld: null,
	
		routes:
		{
			"moduleSelect/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("ModuleTree").isLoaded() == false)
					{					
						this.getStore("ModuleTree").on("load",
							function()
							{
							action.resume();	
							},
							null,
							{
							single: true	
							}
						);
					}
					else action.resume();
				},
				action: function(id)
				{
					if(this.idOld != id)
					{
					this.idOld = id;
					this.select(id);
					}
				}
			}
		},
		
		refs: 
		{
		tree: "ModuleTemplate\\.view\\.ModuleTree[name='ModuleTree']",
		grid: "ModuleTemplate\\.view\\.ModuleTemplateGrid[name='ModuleTree']"
		},
	
		control:
		{
			"ModuleTemplate\\.view\\.ModuleTree[name='ModuleTree'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("treepanel").getStore().load();
				}	
			},
			"ModuleTemplate\\.view\\.ModuleTree[name='ModuleTree']":
			{
				beforeselect: function(modelSel, record, index, eOpts)
				{								
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "moduleSelect",
							value: record.getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			}
		},
		
		select: function(id)
		{
		id = id == -1 ? null : id;
		this.getGrid().getStore().getProxy().setExtraParam("idModule", id);
		this.getGrid().getStore().load();
		
			if(id)
			{
			var record = this.getTree().getStore().getById(id);
			this.getTree().getSelectionModel().select(record, null, true);
			
			this.getGrid().setTitle("Шаблоны: " + record.getData().text);
			
				if(this.getGrid().getButtonCreate())
				{
				this.getGrid().getButtonCreate().setDisabled(false);	
				this.getGrid().getMenuItemCreate().setDisabled(false);
				}
			}
			else
			{
			this.getGrid().setTitle("Шаблоны");
			
				if(this.getGrid().getButtonCreate())
				{
				this.getGrid().getButtonCreate().setDisabled(true);	
				this.getGrid().getMenuItemCreate().setDisabled(true);
				}
			}
		}
	}
);