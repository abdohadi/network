import Errors from './Errors';

class Form 
{
	constructor() 
	{
		this.errors = new Errors();
	}

	setData(data)
	{
		this.data = data;
	}
}

export default Form;