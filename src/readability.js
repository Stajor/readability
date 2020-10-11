const { Readability } = require('@mozilla/readability');
const JSDOM = require('jsdom').JSDOM;

const params = process.argv.slice(2);

const doc = new JSDOM(params[1], {url: params[0]});
const reader = new Readability(doc.window.document);
const article = reader.parse();

process.stdout.write(JSON.stringify(article));
