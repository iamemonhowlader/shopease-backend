"use client";

import { useSearchParams } from "next/navigation";
import { useQuery } from "@tanstack/react-query";
import { getSales } from "@/lib/api";
import { SaleFilters } from "@/lib/types";
import FilterBar from "@/components/sales/FilterBar";
import SalesTable from "@/components/sales/SalesTable";
import Pagination from "@/components/sales/Pagination";

export default function SalesPage() {
  const searchParams = useSearchParams();
  
  const filters: SaleFilters = {
    branch: searchParams.get("branch") || "",
    from: searchParams.get("from") || "",
    to: searchParams.get("to") || "",
    category: searchParams.get("category") || "",
    payment_method: searchParams.get("payment_method") || "",
  };
  
  const page = parseInt(searchParams.get("page") || "1");

  const { data, isLoading, isError } = useQuery({
    queryKey: ["sales", filters, page],
    queryFn: () => getSales(filters, page),
    placeholderData: (previousData) => previousData,
  });

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-3xl font-bold text-slate-900">Sales Records</h1>
        <p className="text-slate-500 mt-2">Manage and monitor all wholesale transactions.</p>
      </div>

      <FilterBar filters={filters} />

      <div className="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <SalesTable 
          sales={data?.data || []} 
          isLoading={isLoading} 
          isError={isError} 
        />
        
        {data && (
          <div className="px-6 py-4 border-t border-slate-50 bg-slate-50/50">
            <Pagination 
              currentPage={data.current_page} 
              lastPage={data.last_page} 
              total={data.total}
              from={data.from}
              to={data.to}
            />
          </div>
        )}
      </div>
    </div>
  );
}
