import axios from 'axios';
import { 
  ImportResponse, 
  PaginatedSales, 
  SaleFilters, 
  SummaryResponse, 
  JobResponse, 
  ExportStatusResponse 
} from './types';

const API_URL = process.env.NEXT_PUBLIC_API_URL;

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

export const importCsv = async (file: File): Promise<ImportResponse> => {
  const formData = new FormData();
  formData.append('file', file);
  const { data } = await api.post<ImportResponse>('/import', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });
  return data;
};

export const getSales = async (filters: SaleFilters, page: number = 1): Promise<PaginatedSales> => {
  const { data } = await api.get<PaginatedSales>('/sales', {
    params: { ...filters, page },
  });
  return data;
};

export const getSummary = async (): Promise<SummaryResponse> => {
  const { data } = await api.get<SummaryResponse>('/summary');
  return data;
};

export const exportCsv = async (filters: SaleFilters): Promise<Blob | JobResponse> => {
  const { data, headers } = await api.get('/export/csv', {
    params: filters,
    responseType: 'blob',
  });

  // If response is JSON (background job)
  if (headers['content-type']?.includes('application/json')) {
    const text = await data.text();
    return JSON.parse(text) as JobResponse;
  }

  return data as Blob;
};

export const exportExcel = async (filters: SaleFilters): Promise<Blob | JobResponse> => {
  const { data, headers } = await api.get('/export/excel', {
    params: filters,
    responseType: 'blob',
  });

  if (headers['content-type']?.includes('application/json')) {
    const text = await data.text();
    return JSON.parse(text) as JobResponse;
  }

  return data as Blob;
};

export const checkExportStatus = async (jobId: string): Promise<ExportStatusResponse> => {
  const { data } = await api.get<ExportStatusResponse>(`/export/status/${jobId}`);
  return data;
};

export default api;
