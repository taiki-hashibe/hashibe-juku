import * as t from "io-ts";

export const ResumableMessageT = t.type({
    path: t.string,
    name: t.string,
    full_path: t.string,
    mime_type: t.string,
});

export type BlogsDetailJsonType = t.TypeOf<typeof ResumableMessageT>;
