export const fetchWithToken = (url, options = {}) => {
    return new Promise(async (resolve, reject) => {
        let res, data;
        try {
            res = await fetch(url, {
                ...options,
                headers: {
                    ...options.headers,
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });
            data = await res.json();
            resolve({ res, data });
        } catch (error) {
            reject({ res, data, error });
        }
    });
};
