import "../scss/admin.scss";
import { videoUpload } from "./admin/videos/videoUpload";
videoUpload();
import Alpine from "alpinejs";
window.Alpine = Alpine;

Alpine.start();

import Sortable from "sortablejs";
const categoryList = document.getElementById("category-list");
if (categoryList) {
    Sortable.create(categoryList, {
        animation: 100,
    });
}
const postList = document.getElementById("post-list");
if (postList) {
    Sortable.create(postList, {
        animation: 100,
    });
}
