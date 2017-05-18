Ext.define('Filesystem.view.FilesystemDirTree', 
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Filesystem.view.FilesystemDirTree',
	
		requires:
		[
		"Filesystem.view.field.FilesystemDirNameText"
		],
	
	name: "Filesystem",
	store: "Dir",
	
		selModel:
		{
		xtype: "treemodel", 
		mode: "SINGLE"
		},
		
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "Filesystem.view.FilesystemFileAndDir"
			}
		},
	
	canUpdateFirstNode: false,
	canDeleteFirstNode: false,
	filter: true,
	
	region: 'west',
	width: 300,
	title: "Папки",
	split: true,
	rootVisible: true,
	collapsible: true,
	forceFit: true,
	hideHeaders: true,
	margin: '5 0 5 5',
	
		columns:
		[
			{
			xtype: 'treecolumn',
			text: 'Название',
			sortable: false,
			dataIndex: 'name',
			width: "100%",
				editor: 
				{
				xtype: "Filesystem.view.field.FilesystemDirNameText",
				hideLabel: true	
				}
			},
		],
	
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			},
			{
			type: 'collapse',
			tooltip: 'Свернуть папки',
			itemId: 'collapse'
			}
		],
		listeners:
		{
			afterEditUpdate: function(success, operation, editor, context)
			{			
				if(success == true)
				{
				var result = Ext.decode(operation.getResponse().responseText);
				
				context.record.set("text", result.data.name);
				context.record.set("name", result.data.name);
				context.record.set("path", result.data.path);	
				}				
			}
		},
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Добавить",
			hidden: !Admin.getApplication().Access.is("Filesystem", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Filesystem", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Filesystem", "isDestroy")
			};
			
		this.callParent();
		var thisObj = this;
			
			this.getView().on("beforedrop",
				function(node, dragData, overModel, dropPosition, dropHandlers, eOpts)
				{					
					function request(params, index)
					{
					var indexCur = index;
						
						Ext.Ajax.request
						(
							{
							url: '_api/Filesystem/FilesystemDirAdminController/move/',
							method: "POST",
							params: params,								
								success: function(response, options)
								{
								var jsonObj = Ext.util.JSON.decode(response.responseText);
								
									if(jsonObj["success"] == true)
									{										
										if(nodeDropCurrent[0].isNode != true) thisObj.up("panel").down("grid").getStore().remove(nodeDropCurrent[indexCur]);
										
										if(nodeDropCurrent[0].isNode != true && targetNodeCurrent.isLoaded() == true && nodeDropCurrent[0].getData().type == "dir")
										{
										var data = nodeDropCurrent[indexCur].getData();
										data["text"] = data["name"];
										var NodeNew = targetNodeCurrent.createNode(data);
										}
									
										if(nodeDropCurrent[0].isNode != true)
										{
										var NodeDelete = thisObj.getStore().getNodeById(nodeDropCurrent[indexCur].getId());
										
											if(NodeDelete) NodeDelete.remove(false);	
										}
										
										if(params["type"] == "dir")
										{								
										nodeDropCurrent[indexCur].set("path", jsonObj["data"]["path"]);
										nodeDropCurrent[indexCur].set("parentPath", jsonObj["data"]["parentPath"]);
										}
										
										if(nodeDropCurrent[0].isNode != true && targetNodeCurrent.isLoaded() == true && nodeDropCurrent[0].getData().type == "dir")
										{
										targetNodeCurrent.insertBefore(NodeNew);
										}
									}
									else if(jsonObj["success"] == false)
									{									
										if(jsonObj["errortype"] == "noDir")
										{
											Ext.Msg.show
											(
												{
												title: "Ошибка!",
												msg: "Директория, в которую вы хотите перенести папку, не найдена!",
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
					
					for(var i = 0; i < nodeDropCurrent.length; i++)
					{
						var params = 
						{
						pathTarget: targetNodeCurrent.getId(),
						pathFrom: nodeDropCurrent[i].getData().path,
						nameFull: nodeDropCurrent[i].getData().nameFull,
						type: nodeDropCurrent[i].getData().type
						};
						
					request(params, i);
					}
					
					if(nodeDropCurrent[0].isNode == true) return true;
					else return false
				}
			);		
			
		var targetNodeCurrent, nodeDropCurrent;
			
			this.getView().on("nodedragover",
				function(targetNode, position, dragData, e, eOpts)
				{
					for(var i = 0; i < dragData.records.length; i++)
					{
						if(dragData.records[i].getData().type == "file")
						{
							if(targetNode.getId() == dragData.records[i].getData().dirPath) return false;
						}
						
						if(dragData.records[i].getData().type == "dir")
						{
							if(targetNode.getId() == dragData.records[i].getData().path) return false;
							if(targetNode.getId() == dragData.records[i].getData().parentPath) return false;
						}
					}
					
				targetNodeCurrent = targetNode;
				nodeDropCurrent = dragData.records;
				
					if(position == "append") return true;
					
				return false;
				}
			);
		}
	}
);