Ext.define("Admin.view.ux.TextPrice",
	{
	extend: "Ext.form.field.Text",
	xtype: "textPrice",
	alias: 'widget.textPrice',

	_val: null,
	_isFocus: false,

		initComponent: function()
		{
			if(this.value)
			{
			this._val = this._trim(this.value);
			this.setValue(Weborobot.Util.getMoney(this.value));
			}

		this.callParent();
		},
		listeners:
		{
			focus: function(text, event, eOpts)
			{
			this._isFocus = true;
			this.setValue(this._trim(this.getValue()));
			},
			blur: function(text, event , eOpts)
			{
			this._isFocus = false;
			this.setValue(Weborobot.Util.getMoney(this.getValue()));
			}
		},

		setValue: function(value)
		{
			if(value) this._val = this._trim(value);

			if(this._isFocus == false)
			{
			value = this._trim(value);
			value = Weborobot.Util.getMoney(value);
			}

		return this.callParent([value]);
		},

		getRawValue: function()
		{
		this._val = this._trim(this.callParent());
		return this._val;
		},

		getValue: function()
		{
		this._val = this._trim(this.callParent());
		return this._val;
		},

		getErrors: function(value)
		{
		return this.callParent([this.getValue()]);
		},

		_trim: function(value)
		{
			if(value !== "" && value !== undefined && value !== null)
			{
			value = value.toString();
			var re = new RegExp(" ", "g");
			value = value.replace(re, "");

			re = new RegExp(",", "g");
			value = value.replace(re, ".");
			}

		return value;
		}
	}
);