Vue.use(Vuex);

const state = {

	_data: {
		data         : [],
		current_page : 1,
		from         : 1,
		last_page    : 1,
		next_page_url: null,
		per_page     : 25,
		prev_page_url: null,
		to           : 1,
		total        : 0,
	}
};

const getters = {
	/**
	 * Return records list
	 */
	records: state => state._data.data,

	/**
	 * Return all data
	 */
	allData: state => state._data,

};

const mutations = {
	/**
	 * Set data
	 */
	setData: (state, data) => {
		state._data = data;
	},

	/**
	 * Insert a new record
	 */
	insertRecord: (state, record) => {
		state._data.data.push(record);
	},

	/**
	 * Update an existing record
	 */
	updateRecord: (state, payload) => {
		let getters = payload.getters;
		let record  = payload.record;
		let index   = getters.records
			.map(el => el.id)
			.indexOf(record.id);
		 if (-1 == index){
            return;
        }

		// Update record
		state._data.data[index].name       = record.name;
	},

	/**
	 * Delete a gatedevice
	 */
	deleteRecord: (state, index) => {
		state._data.data.splice(index, 1);
	}
};

const actions = {

	/**
	 * Load records data
	 */
	loadRecords(context, page) {
		return new Promise((resolve, reject) => {
			axios.get('/gatePlans?page=' + page)
				.then(res => {
					// Add "selected" property to items
					let allData = res.data;
					let rowData = allData.data;

					rowData = rowData.map(x => {
						x.selected = false;

						return x;
					});

					// Set data
					context.commit('setData', allData);

					resolve(res);
				})
				.catch(err => {
					// Empty List
					context.commit('setData', []);

					resolve(err);
				});
		});
	},

	/**
	 * save gate_plan
	 */
	saveRecord: (context, record) => {
		return new Promise((resolve, reject) => {
			// New record
			if (0 == record.id) {
				axios.post('/gatePlans', record)
					.then(res => {

						let status    = (0 == res.data.status);
						let newRecord = res.data.gatePlan;

						if (null != newRecord) {
							context.commit('insertRecord', newRecord);
						}

						resolve(status);
					})
					.catch(err => reject(err));
			}

			// Update record
			else {
				axios.put('/gatePlans/' + record.id, record)
					.then(res => {
						let status       = (0 == res.data.status);
						let updatedRecord = res.data.gatePlan;

						if (null != updatedRecord) {
							context.commit('updateRecord',{
									getters: context.getters,
									record : updatedRecord
								});
						}

						resolve(status);
					})
					.catch(err => reject(err));
			}
		});
	},

	/**
	 * Delete a Record
	 */
	deleteRecord(context, id) {
		return new Promise((resolve, reject) => {
			// Get item index
			let index = context.getters.records
				.map(el => el.id)
				.indexOf(id);

			// Record not found!
			if (-1 == index) {
				reject({
					message: 'رکورد مورد نظر یافت نشد',
				});

				return;
			}

			// Try to delete
			axios.delete('/gatePlans/' + id)
				.then(res => {
					if (0 == res.data.status){
						// Remove form nationalities list
						context.commit('deleteRecord', index);

						resolve(res);

						return;
					}

					reject({
						message: 'امکان حذف وجود ندارد'
					});
				})
				.catch(err => {
					reject(err);
				});
		});
	}
};

export default new Vuex.Store({
	state,
	getters,
	mutations,
	actions,
});
