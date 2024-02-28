import "../scss/admin.scss";
import { videoUpload } from "./admin/videos/videoUpload";
videoUpload("video");
videoUpload("video_free");

import Sortable from "sortablejs";

function setupSortable(id : string) {
    const list = document.getElementById(id);
    if (list) {
        Sortable.create(list, {
            animation: 100,
        });
    }

}
setupSortable("category-list");
setupSortable("post-list");
setupSortable("curriculum-list");
setupSortable("curriculum-post-list");
setupSortable("sort-list");
