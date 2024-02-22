import { isLeft } from "fp-ts/lib/Either";
import * as t from "io-ts";

export const only = <T>(value: t.Validation<T>, log?: boolean): T | false =>
    isLeft(value)
        ? ((): false => {
              log ? value.left.map((e) => console.error(e)) : void 0;
              return false;
          })()
        : value.right;
export const array = <T>(value: t.Validation<T>[], log?: boolean): T[] => {
    const result: T[] = [];
    value.filter((v) => {
        const res = only(v, log);
        res ? result.push(res) : void 0;
    });

    return result;
};

export interface IConverter {
    only: <T>(value: t.Validation<T>, log?: boolean) => T | false;
    array: <T>(value: t.Validation<T>[], log?: boolean) => T[];
}

const convert: IConverter = {
    only,
    array,
};

export default convert;
