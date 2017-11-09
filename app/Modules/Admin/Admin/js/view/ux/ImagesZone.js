Ext.Loader.loadScript
(
	{
	url: "bower_modules/extjs/build/packages/ux/classic/ux-debug.js"
	}
);

Ext.Loader.setPath('Ext.ux.DataView.Draggable', 'bower_modules/extjs/packages/ux/classic/src/DataView/Draggable.js');
Ext.Loader.setPath('Ext.ux.DataView.DragSelector', 'bower_modules/extjs/packages/ux/classic/src/DataView/DragSelector.js');

Ext.define("Admin.view.ux.ImagesZone",
	{
	extend: "Ext.DataView",
	xtype: 'imagesZone',
	alias: 'widget.imagesZone',
	layout: "fit",

	itemSelector: "div.imagesZone-item",
	nameImage: "id_imageSmall",
	nameLabel: null,
	cls: "imagesZone",

	overClass: 'imagesZone-item-over',
	trackOver: true,

	scrollable: true,

		allowFormats:
		{
		jpg: true,
		jpeg: true,
		png: true,
		gif: true
		},

		addFormat: function(format)
		{
			if(this.allowFormats[format.toLowerCase()]) this.allowFormats[format.toLowerCase()] = true;

		return this;
		},
		deleteFormat: function(format)
		{
			if(this.allowFormats[format.toLowerCase()]) this.allowFormats[format.toLowerCase()] = false;

		return this;
		},
		getFormats: function()
		{
		var formats = [];

			for(k in this.allowFormats)
			{
				if(this.allowFormats[k] == true) formats[formats.length] = k;
			}

		return formats;
		},
		isFormat: function(name)
		{
		var formats = this.getFormats();

			for(var i = 0; i < formats.length; i++)
			{
				if(name.toLowerCase().lastIndexOf("." + formats[i]) != -1) return true;
			}

		return false;
		},

		style:
		{
		borderColor: '#157fcc',
		borderStyle: 'solid',
		padding: '10px'
		},

		load: function(files, url, data, callback)
		{
		var Xhr = new XMLHttpRequest(),
			me = this,
			Progress = Ext.MessageBox.progress("Загрузка и обработка изображений", "Идет загрузка изображений, подождите...", "Загрузка, 0%");

			Xhr.upload.addEventListener('progress',
				function(eve)
				{
				var percent = parseInt(eve.loaded / eve.total * 100);

					if(percent != 100) Progress.updateProgress((percent - 20) / 100, "Загрузка, " + (percent - 20) + "%", "Идет загрузка изображений, подождите...");
					else Progress.updateProgress((percent - 20) / 100, "Обработка, " + (percent - 20) + "%", "Идет обработка изображений, подождите...");
				}
			, false);

			Xhr.onreadystatechange = function(eve)
			{
				if(eve.target.readyState == 4)
				{
				Progress.updateProgress(1, "Обработка, 100%", "Заканчиваем...");

					window.setTimeout
					(
						function()
						{
						Ext.MessageBox.hide();

							if(eve.target.status == 200)
							{
							var result = Ext.JSON.decode(eve.target.responseText);

								if(result["success"] == true)
								{
									if(callback) callback.call(me);
								}
								else
								{
									if(result.errormsg)
									{
										Ext.Msg.show
										(
											{
											title: "Ошибка!",
											msg: result.errormsg,
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
						},
						200
					);
				}
			};

		Xhr.open('POST', url);
		var Fd = new FormData();

			if(data)
			{
				for(k in data)
				{
				Fd.append(k, data[k]);
				}
			}

			for(var i = 0; i < files.length; i++)
			{
			Fd.append("image[" + i + "]", files[i]);
			}

		Xhr.send(Fd);
		},

		_cleanDragstart: function(items)
		{
			for(var i = 0; i < items.length; i++)
			{
				if(items[i]) items[i].ondragstart = function() {return false;};
			}
		},

		listeners:
		{
			refresh: function(v)
			{
			v._cleanDragstart(v.getEl().query(v.itemSelector));
			},
			render: function(v)
			{
			var drop = null;

				v.DragZone = Ext.create('Ext.dd.DragZone', v.getEl(),
					{
					ddGroup: 'imagesZone',
						getDragData: function(e)
						{
						var sourceEl = e.getTarget(v.itemSelector, 10),
							d;
						v._cleanDragstart([sourceEl]);

							if(sourceEl)
							{
							d = sourceEl.cloneNode(true);
							d.id = Ext.id();

								return (v.dragData =
									{
									sourceEl: sourceEl,
									repairXY: Ext.fly(sourceEl).getXY(),
									ddel: d,
									data: v.getRecord(sourceEl).data,
									record: v.getRecord(sourceEl),
									store: v.store
									}
								);
							}
						},
						getRepairXY: function()
						{
						return this.dragData.repairXY;
						},
						onMouseUp: function()
						{
							if(drop)
							{
							v.fireEventArgs("drop", drop);
							drop = null;
							}

						return true;
						},
						onBeforeDrag: function()
						{
						v._cleanDragstart(v.getEl().query(v.itemSelector));
						return v.fireEventArgs("beforedrag");
						}
					}
				);

				v.DropZone = Ext.create('Ext.dd.DropZone', v.getEl(),
					{
					ddGroup: 'imagesZone',
						getTargetFromEvent: function(e)
						{
						return e.getTarget('.imagesZone-item');
						},
						onNodeEnter: function(target, dd, e, data)
						{
							if(target)
							{
							var recordOver = v.getRecord(target);
							var indexOver = v.getStore().indexOf(recordOver);
							var indexOn = v.getStore().indexOf(data.record);

								var status = v.fireEventArgs("beforedrop",
									[
									data.record.getId(),
									indexOver,
									indexOn,
									data.record,
									data.data
									]
								);

								if(status)
								{
								data.record.set("_fake", 1);

									if(indexOn != indexOver)
									{
										if(indexOn < indexOver)
										{
										var counter = 0;

											v.getStore().each
											(
												function(rec)
												{
													if(counter > indexOn && counter <= indexOver)
													{
													v.getStore().insert(counter - 1, rec);
													}

												counter++;
												}
											);
										}
										else if(indexOn > indexOver) v.getStore().insert(indexOver, data.record);

										drop =
										[
										data.record.getId(),
										indexOver,
										indexOn,
										data.record,
										data.data
										];
									}
								}
							}
						},
						onNodeOut: function(target, dd, e, data)
						{
						data.record.set("_fake", null);
						},
						onNodeOver: function(target, dd, e, data)
						{
						v._cleanDragstart(v.getEl().query(v.itemSelector));
						return Ext.dd.DropZone.prototype.dropAllowed;
						},
						onNodeDrop: function(target, dd, e, data)
						{
							v.getStore().each
							(
								function(rec)
								{
								rec.set("_fake", null);
								}
							);

						return true;
						}
					}
				);

				if(window.File && window.FileList && window.FileReader)
				{
					v.target = new Ext.drag.Target
					(
						{
						element: v.getEl(),
							listeners:
							{
							scope: v,
								dragenter: function(target, info)
								{
								v.getEl().parent().query(".icon", false)[0].addCls("active");
								},
								dragleave: function(target, info)
								{
								v.getEl().parent().query(".icon", false)[0].removeCls("active");
								},
								drop: function(target, info)
								{
								v.getEl().parent().query(".icon", false)[0].removeCls("active");
								var filesSend = [];

									for(var i = 0, f = 0; i < info.files.length; i++)
									{
										if(v.isFormat(info.files[i].name))
										{
										filesSend[f] = info.files[i];
										f++;
										}
									}

									v.fireEventArgs("loading",
										[
										filesSend
										]
									);
								}
							}
						}
					);
				}
			}
		},

		initComponent: function()
		{
		this.tpl = this._getTpl();
		this.callParent();
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

		setNameImage: function(nameImage)
		{
		this.nameImage = nameImage;
		this.setTpl(this._getTpl());
		return this;
		},
		getNameImage: function()
		{
		return this.nameImage;
		},

		setNameLabel: function(nameLabel)
		{
		this.nameLabel = nameLabel;
		this.setTpl(this._getTpl());
		return this;
		},
		getNameLabel: function()
		{
		return this.nameLabel;
		},

		_getTpl: function()
		{
		var label = "none",
			icon = "icon";

			if(this.getNameLabel()) label = "block";
			if(!window.File || !window.FileList || !window.FileReader) icon += " noSupport";

		return '<tpl for=".">' +
					'<div class="imagesZone-item <tpl if=\"_fake == 1\">isFake</tpl>">' +
						'<img src="{' + this.getNameImage() + '.path}" />' +
						'<div class="imagesZone-content-label" style="display: ' + label + '">{' + this.getNameLabel() + '}</div>' +
					'</div>' +
				'</tpl>' +
				'<div class="' + icon + '"></div>';
		}
	}	
);