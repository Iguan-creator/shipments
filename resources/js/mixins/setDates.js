export default {
    methods: {
        today() {
            return this.getDate();
        },

        monthsAgo(months) {
            return this.getDate(months);
        },

        getDate(months = false) {
            let date = new Date();

            if (months) {
                date.setMonth(date.getMonth() - months);
            }

            return date.toISOString().slice(0, 10);
        }
    }
}
