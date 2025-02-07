import { goto } from "$app/navigation";
import { browser } from '$app/environment';
import dayjs from "dayjs";
import pkg from 'notiflix';
const { Notify, Confirm } = pkg;


// gets the currently logged admin 
// export const current_lia = () => {

//     const decoded_lia = decode_current_lia();

//     // console.log(decoded_lia);

//     if (!decoded_lia) {
//         return;
//     }


//     if (decoded_lia.account_type != 'branch') {
//         return {
//             authenticated: true,
//             user: decoded_lia.users[0],
//             users: decoded_lia.users

//         };
//     }


//     return {
//         authenticated: false,
//         callback: authenticate_action,
//         users: decoded_lia.users
//     }
// }



export const format_date = (d, format) => {

    // format desctribe how to format the date 
    if (!format) {

        if (d.length > 12) {
            format = "MMM DD, YYYY H:m:s"
        } else {
            format = "'MMM DD, YYYY";

        }
    }

    // if date includes time
    if (d.length > 12) {
        return dayjs(d).format(format);

    } else {
        return dayjs(d).format(format);

    }
}



export const add_commas = (number, dp) => {


    return number.toLocaleString("en-US", {
        minimumFractionDigits: dp,
        maximumFractionDigits: dp,
    });
}

//current liu
export const current_liu = () => {

    let liu = {};

    if (browser) {

        let clia = window.localStorage.invema_liu;

        if (!clia) {
            goto('/');

            return;
        }

        liu = JSON.parse(clia);
    }

    return liu;
}
//logout
export const logout = () => {
    // session id to logout
    Confirm.show(
        "Logout",
        `Logout this device?`,
        "Yes",
        "No",
        () => {
            let ck = "invema_liu";

            window.sessionStorage.removeItem('invema_liu');

            goto("/", { replaceState: true });

        },
        () => {
            //    do nothing
        },
        {}
    );
}

