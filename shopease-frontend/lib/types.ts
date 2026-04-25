export interface ImportStats {
  total: number;
  inserted: number;
  skipped_duplicate: number;
  skipped_invalid: number;
  error_log_url?: string | null;
}

export interface ImportResponse {
  total: number;
  inserted: number;
  skipped_duplicate: number;
  skipped_invalid: number;
  error_log_url: string | null;
}

export interface Sale {
  id: number;
  sale_id: string;
  branch: string;
  sale_date: string;
  product_name: string;
  category: string | null;
  quantity: number;
  unit_price: string;
  discount_pct: string;
  payment_method: string;
  salesperson: string;
  revenue: string;
  created_at: string;
  updated_at: string;
}

export interface SaleFilters {
  branch?: string;
  from?: string;
  to?: string;
  category?: string;
  payment_method?: string;
}

export interface PaginatedSales {
  data: Sale[];
  current_page: number;
  last_page: number;
  total: number;
  per_page: number;
  from: number;
  to: number;
}

export interface TopProduct {
  product_name: string;
  total_revenue: string;
}

export interface BranchBreakdown {
  branch: string;
  orders_count: number;
  total_qty: number;
  total_revenue: string;
}

export interface SummaryResponse {
  total_revenue: number;
  total_quantity: number;
  total_orders: number;
  avg_order_value: number;
  top_products: TopProduct[];
  branch_breakdown: BranchBreakdown[];
}

export interface JobResponse {
  job_id: string;
  status: 'processing' | 'ready' | 'failed';
  message?: string;
}

export interface ExportStatusResponse {
  status: 'processing' | 'ready' | 'failed';
  download_url?: string;
}
