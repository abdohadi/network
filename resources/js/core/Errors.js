
class Errors 
{
	constructor()
	{
		this.errors = {};
	}

	record(errors)
	{
		this.errors = errors;
	}

	has(field)
	{
		if (this.errors) {
			return this.errors.hasOwnProperty(field);
		}
	}

	get(field)
	{
		if (this.errors) {
			if (this.errors[field]) {
				return this.errors[field][0];
			}
		}	
	}

	any()
	{
		return Object.keys(this.errors).length > 0;
	}
}

export default Errors;