import * as t from "io-ts";

const only = <T>(value: unknown, type: t.Type<T>): t.Validation<T> =>
    type.decode(value);
const array = <T>(value: unknown[], type: t.Type<T>): t.Validation<T>[] =>
    value.map((v) => only<T>(v, type));

export interface IDecoder {
    only: <T>(value: unknown, type: t.Type<T>) => t.Validation<T>;
    array: <T>(value: unknown[], type: t.Type<T>) => t.Validation<T>[];
}

const decoder: IDecoder = {
    only,
    array,
};

export default decoder;
