const salt = 'salt';
const iv = '1111111111111111';
const iterations = 999;

export function getKey(passphrase, salt){
    var key = window.CryptoJS.PBKDF2(passphrase, salt, {
        hasher: window.CryptoJS.algo.SHA256,
        keySize: 64 / 8,
        iterations: iterations
    });
    return key;
}
export function userJSEncrypt(passphrase, plainText){
    var key = getKey(passphrase, salt);
    var encrypted = window.CryptoJS.AES.encrypt(plainText, key, {
        iv: window.CryptoJS.enc.Utf8.parse(iv)
    });
    return encrypted.ciphertext.toString(window.CryptoJS.enc.Base64);
}
export function userJSDecrypt(passphrase, encryptedText){
    var key = getKey(passphrase, salt);
    var decrypted = window.CryptoJS.AES.decrypt(encryptedText, key, {
        iv: window.CryptoJS.enc.Utf8.parse(iv)
    });
    return decrypted.toString(window.CryptoJS.enc.Utf8);
}

export function try_eval(command) {
    //console.log("Called: " + command);
    eval('try {' + command + '} catch (err) { console.log("Error: " + err ) } ');
}
