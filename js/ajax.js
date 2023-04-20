
async function get_by_city(city) {
    return await (
        await fetch(`backend/controller/ControllerRilevazioni.php/?mode=get_by_city&city=${city}`, {
            method: "GET",
        })
    ).json();
}

async function get_city() {
    return await (
        await fetch(`backend/controller/ControllerRilevazioni.php/?mode=get_city`, {
            method: "GET",
        })
    ).json();
}
