import {Dexie} from 'dexie';

var db = new Dexie('someDB');
db.delete().then(() => {
    db.version(1).stores({
        currency: "lcode, someIndex"
    });
    db.open();
    console.log(db.verno);
})

// Populate from AJAX:
db.on('ready',  (db) => {
    console.log('db is ready');
    // on('ready') event will fire when database is open but
    // before any other queued operations start executing.
    // By returning a Promise from this event,
    // the framework will wait until promise completes before
    // resuming any queued database operations.
    // Let's start by using the count() method to detect if
    // database has already been populated.
    return db.currency.count((count) => {
        if (count > 0) {
            console.log("Already populated");
        } else {
            console.log("Database is empty. Populating from ajax call...");
            // We want framework to continue waiting, so we encapsulate
            // the ajax call in a Promise that we return here.
            return new Promise((resolve, reject) => {
                // const sendUrl = "/api/talks?page=1";
                const sendUrl = "https://www.floatrates.com/daily/usd.json";
                const sendType = "GET";
                fetch(sendUrl, {
                    method: sendType,
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        // https://flexiple.com/javascript/loop-through-object-javascript
                        let arrayValues=[];
                        Object.keys(data).forEach(key => {
                            const value = data[key];
                            value['lcode'] = key;
                            console.log(value);
                            arrayValues.push(value);
                        });
                        console.log(arrayValues, db);
                        return db.currency.bulkAdd(arrayValues);
                    });
            });
        }
    })
});
