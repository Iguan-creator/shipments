export default {
    methods: {
        formatData(data, parameter) {
            if (typeof data === 'object') {
                if (parameter.slice(-1) === 's') {
                    let result = '';
                    data.forEach(element => {
                        result += element.name + ', ';
                    })
                    return result.substring(0, result.length - 2);
                }
                if (data === null) {
                    return null;
                } else {
                    return data.name;
                }


            } else {
                return data;
            }
        }
    }
}


