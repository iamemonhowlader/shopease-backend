"use client";

import { useCallback, useState } from "react";
import { useDropzone } from "react-dropzone";
import { UploadCloud, FileText, X, Loader2 } from "lucide-react";
import { importCsv } from "@/lib/api";
import { ImportResponse } from "@/lib/types";
import { clsx } from "clsx";

interface Props {
  onSuccess: (data: ImportResponse) => void;
  onError: (msg: string) => void;
}

export default function DropZone({ onSuccess, onError }: Props) {
  const [file, setFile] = useState<File | null>(null);
  const [uploading, setUploading] = useState(false);

  const onDrop = useCallback((acceptedFiles: File[]) => {
    if (acceptedFiles.length > 0) {
      setFile(acceptedFiles[0]);
    }
  }, []);

  const { getRootProps, getInputProps, isDragActive } = useDropzone({
    onDrop,
    accept: {
      'text/csv': ['.csv'],
      'text/plain': ['.txt'],
    },
    maxFiles: 1,
    multiple: false
  });

  const handleUpload = async () => {
    if (!file) return;

    setUploading(true);
    try {
      const result = await importCsv(file);
      onSuccess(result);
      setFile(null);
    } catch (err: any) {
      onError(err.response?.data?.message || "Could not connect to server. Is the Laravel API running?");
    } finally {
      setUploading(false);
    }
  };

  return (
    <div className="space-y-6">
      {!file ? (
        <div
          {...getRootProps()}
          className={clsx(
            "border-2 border-dashed rounded-3xl p-12 text-center transition-all duration-300 cursor-pointer",
            isDragActive 
              ? "border-blue-500 bg-blue-50 scale-[0.99]" 
              : "border-slate-200 hover:border-blue-400 hover:bg-slate-50"
          )}
        >
          <input {...getInputProps()} />
          <div className="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-blue-600">
            <UploadCloud className="w-8 h-8" />
          </div>
          <h3 className="text-xl font-bold text-slate-900 mb-1">
            Drop CSV file here or click to browse
          </h3>
          <p className="text-slate-500">Only .csv or .txt files are accepted (Max 50MB)</p>
        </div>
      ) : (
        <div className="border border-slate-200 rounded-2xl p-6 bg-slate-50 flex items-center justify-between">
          <div className="flex items-center gap-4">
            <div className="bg-white p-3 rounded-xl shadow-sm border border-slate-200 text-blue-600">
              <FileText className="w-6 h-6" />
            </div>
            <div>
              <p className="font-bold text-slate-900">{file.name}</p>
              <p className="text-sm text-slate-500">{(file.size / (1024 * 1024)).toFixed(2)} MB</p>
            </div>
          </div>
          <button 
            onClick={() => setFile(null)} 
            className="text-slate-400 hover:text-red-500 transition-colors"
            disabled={uploading}
          >
            <X className="w-6 h-6" />
          </button>
        </div>
      )}

      {file && (
        <button
          onClick={handleUpload}
          disabled={uploading}
          className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-blue-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
        >
          {uploading ? (
            <>
              <Loader2 className="w-5 h-5 animate-spin" />
              Processing rows...
            </>
          ) : (
            "Start Import"
          )}
        </button>
      )}
    </div>
  );
}
