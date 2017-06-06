Ext.define('Publication.view.PublicationSectionTree', 
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Publication.view.PublicationSectionTree',
	
		requires:
		[
		'Publication.view.field.PublicationSectionLabelPublicationText'
		],
	
	name: "Publication",
	store: "PublicationSection",
		
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "Publication.view.PublicationGrid",
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
	width: 310,
	title: "Разделы",
	split: true,
	rootVisible: true,
	collapsible: true,
	margin: '5 0 0 0',
	forceFit: true,
	hideHeaders: true,
		
		columns:
		[
			{
			xtype: 'treecolumn',
			text: 'Название',
			sortable: false,
			dataIndex: 'labelSection',
			width: "100%",
				editor: 
				{
				xtype: 'Publication.view.field.PublicationSectionLabelPublicationText',
				hideLabel: true	
				}
			}
		],
		
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			}
		],
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Добавить",
			hidden: !Admin.getApplication().Access.is("Publication", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Publication", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Publication", "isDestroy")
			};
		
		this.callParent();
		var thisObj = this;		
			
			this.getView().on("beforedrop",
				function(node, dragData, overModel, dropPosition, dropHandlers, eOpts)
				{							
					for(var i = 0; i < nodeDropCurrent.length; i++)
					{
						var url = Weborobot.Util.getUrlToModule("Publication", null, "setSection");
						
						Ext.Ajax.request
						(
							{
							url: url,
							method: "POST",
								params:
								{
								idPublicationSection: targetNodeCurrent.getId(),
								idPublication: nodeDropCurrent[i].getData().idPublication
								},								
								success: function(response, options)
								{
								var jsonObj = Ext.util.JSON.decode(response.responseText);
								
									if(jsonObj["success"] == true)
									{
									thisObj.up("panel").down("grid").getStore().load();
									}
									else
									{
										if(jsonObj["errortype"] == "isExist")
										{
											Ext.Msg.show
											(
												{
												title: "Ошибка!",
												msg: "Одна из выбранных публикаций не может быть добавлена в этот раздел, так как она уже есть в нем!",
												icon: Ext.MessageBox.ERROR,
												buttons: Ext.MessageBox.OK
												}
											);	
										}
										else
										{
											Ext.Msg.show
											(
												{
												title: "Ошибка!",
												msg: "Произошла ошибка выполнения программы на сервере!",
												icon: Ext.MessageBox.ERROR,
												buttons: Ext.MessageBox.OK
												}
											);
										}
									}
								},
								failure: function(response, options)
								{
									Ext.Msg.show
									(
										{
										title: "Ошибка!",
										msg: "Произошла ошибка выполнения программы на сервере!",
										icon: Ext.MessageBox.ERROR,
										buttons: Ext.MessageBox.OK
										}
									);
								}
							}
						);
					}
					
				return false;
				}
			);		
			
		var targetNodeCurrent, nodeDropCurrent;
			
			this.getView().on("nodedragover",
				function(targetNode, position, dragData, e, eOpts)
				{
				targetNodeCurrent = targetNode;
				nodeDropCurrent = dragData.records;
				
					if((position == "before" || position == "after") && targetNodeCurrent.parentNode.isRoot() == true) return false;
					
				return true;
				}
			);
		}
	}
);