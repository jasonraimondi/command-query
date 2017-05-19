export interface RestClientInterface {
  get(path: string, queryParameters: any, headers?: any): any;
  post(path: string, formParameters: any, headers?: any): any;
}